<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Invoicing';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Quotation Details')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->options(Client::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('email')->email(),
                                Forms\Components\TextInput::make('phone'),
                                Forms\Components\TextInput::make('company'),
                            ]),
                        Forms\Components\TextInput::make('quotation_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn() => 'QUO-' . str_pad((Quotation::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT)),
                        Forms\Components\DatePicker::make('quotation_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('currency_id')
                            ->label('Currency')
                            ->options(Currency::all()->pluck('name', 'id'))
                            ->required()
                            ->default(fn() => Currency::where('is_default', true)->first()?->id),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'sent' => 'Sent',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                                'expired' => 'Expired',
                            ])
                            ->required()
                            ->default('draft'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Quotation Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotals($get, $set);
                            })
                            ->deleteAction(
                                fn ($action) => $action->after(fn (Forms\Get $get, Forms\Set $set) => self::updateTotals($get, $set))
                            )
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->options(Product::all()->pluck('name', 'id'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $set('unit_price', $product->price);
                                            $set('description', $product->description);
                                        }
                                    }),
                                Forms\Components\TextInput::make('description')
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Get $get, Forms\Set $set) {
                                        $set('total', $state * $get('unit_price'));
                                        self::updateTotals($get, $set);
                                    }),
                                Forms\Components\TextInput::make('unit_price')
                                    ->required()
                                    ->numeric()
                                    ->step(0.01)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Get $get, Forms\Set $set) {
                                        $set('total', $state * $get('quantity'));
                                        self::updateTotals($get, $set);
                                    }),
                                Forms\Components\TextInput::make('total')
                                    ->required()
                                    ->numeric()
                                    ->step(0.01)
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                            ->columns(5)
                            ->defaultItems(1)
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ]),

                Forms\Components\Section::make('Totals & Notes')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->step(0.01)
                            ->disabled()
                            ->dehydrated()
                            ->live()
                            ->afterStateHydrated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotals($get, $set);
                            }),
                        Forms\Components\TextInput::make('discount')
                            ->numeric()
                            ->step(0.01)
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotals($get, $set);
                            }),
                        Forms\Components\TextInput::make('tax_percentage')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotals($get, $set);
                            }),
                        Forms\Components\TextInput::make('tax_amount')
                            ->numeric()
                            ->step(0.01)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->step(0.01)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Textarea::make('first_note')
                            ->label('First Note')
                            ->rows(2),
                        Forms\Components\Textarea::make('second_note')
                            ->label('Second Note')
                            ->rows(2),
                        Forms\Components\FileUpload::make('signature')
                            ->image()
                            ->imageEditor(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quotation_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.symbol')
                    ->label('Currency'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'expired' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'expired' => 'Expired',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Quotation $record): string => route('quotations.download', $record)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        // Get all items and calculate subtotal
        $items = $get('items') ?? [];
        $subtotal = collect($items)->sum('total');
        
        // Get discount and tax percentage
        $discount = (float) ($get('discount') ?? 0);
        $taxPercentage = (float) ($get('tax_percentage') ?? 0);
        
        // Calculate totals
        $afterDiscount = $subtotal - $discount;
        $taxAmount = ($afterDiscount * $taxPercentage) / 100;
        $total = $afterDiscount + $taxAmount;
        
        // Set the calculated values
        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('tax_amount', number_format($taxAmount, 2, '.', ''));
        $set('total', number_format($total, 2, '.', ''));
    }
}
