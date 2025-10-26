<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Invoicing';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Invoice Details')
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
                            ])
    ->createOptionUsing(function (array $data) {
        return \App\Models\Client::create($data)->getKey();
    }),
                        Forms\Components\TextInput::make('invoice_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn() => 'INV-' . str_pad((Invoice::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT)),
                        Forms\Components\DatePicker::make('invoice_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('currency_id')
                            ->label('Currency')
                            ->options(Currency::all()->pluck('name', 'id'))
                            ->required()
                            ->default(fn() => Currency::where('is_default', true)->first()?->id),
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'Bank Transfer',
                                'credit_card' => 'Credit Card',
                                'check' => 'Check',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Invoice Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotals($get, $set);
                            })
                            ->deleteAction(
                                fn($action) => $action->after(fn(Forms\Get $get, Forms\Set $set) => self::updateTotals($get, $set))
                            )
                            ->addAction(
                                fn($action) => $action->after(fn(Forms\Get $get, Forms\Set $set) => self::updateTotals($get, $set))
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
                                            $set('price', $product->price);
                                            $set('description', $product->description);
                                        }
                                    }),
                                Forms\Components\TextInput::make('description')
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $quantity = (float) ($state ?? 0);
                                        $unitPrice = (float) ($get('price') ?? 0);
                                        $total = $quantity * $unitPrice;
                                        $set('total', $total);
                                        self::updateTotals($get, $set);
                                    }),
                                Forms\Components\TextInput::make('price')
                                    ->label('Unit Price')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $unitPrice = (float) ($state ?? 0);
                                        $quantity = (float) ($get('quantity') ?? 0);
                                        $total = $quantity * $unitPrice;
                                        $set('total', $total);
                                        self::updateTotals($get, $set);
                                    }),
                                Forms\Components\TextInput::make('total')
                                    ->label('Total')
                                    ->required()
                                    ->numeric()
                                    ->step(0.01)
                                    ->disabled(fn() => true) // display as readonly
                                    ->dehydrated(true)        // still save to DB
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                        self::updateTotals($get, $set);
                                    }),
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
                            ->default(0)
                            ->step(0.01)
                            ->disabled(fn() => true)
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
                            ->default(0)
                            ->step(0.01)
                            ->disabled(fn() => true)
                            ->dehydrated(),
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->disabled(fn() => true)
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
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_date')
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
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_method')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
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
                    ->url(fn(Invoice $record): string => route('invoices.download', $record)),
                Tables\Actions\Action::make('convertToQuotation')
                    ->label('Convert to Quotation')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Convert Invoice to Quotation')
                    ->modalDescription('This will create a new quotation with all the details from this invoice.')
                    ->modalSubmitActionLabel('Convert')
                    ->action(function (Invoice $record) {
                        // Load items relationship
                        $record->load('items');
                        
                        // Create new quotation from invoice
                        $quotation = \App\Models\Quotation::create([
                            'client_id' => $record->client_id,
                            'quotation_number' => 'QUO-' . str_pad((\App\Models\Quotation::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
                            'quotation_date' => now(),
                            'subtotal' => $record->subtotal,
                            'discount' => $record->discount,
                            'tax_percentage' => $record->tax_percentage,
                            'tax_amount' => $record->tax_amount,
                            'total' => $record->total,
                            'signature' => $record->signature,
                            'first_note' => $record->first_note,
                            'second_note' => $record->second_note,
                            'status' => 'pending',
                            'currency_id' => $record->currency_id,
                        ]);

                        // Copy invoice items to quotation items
                        foreach ($record->items as $item) {
                            \App\Models\QuotationItem::create([
                                'quotation_id' => $quotation->id,
                                'product_id' => $item->product_id ?? null,
                                'description' => $item->description ?? '',
                                'quantity' => $item->quantity ?? 1,
                                'unit_price' => $item->price ?? 0,
                                'total' => $item->total ?? 0,
                            ]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Quotation Created')
                            ->success()
                            ->body("Quotation {$quotation->quotation_number} has been created from invoice {$record->invoice_number}.")
                            ->send();

                        return redirect()->route('filament.admin.resources.quotations.edit', ['record' => $quotation->id]);
                    }),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
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
        $subtotal = 0;

        // Calculate subtotal from items
        foreach ($items as $index => $item) {
            if (isset($item['total'])) {
                $item['total'] = ((float) ($item['quantity'] ?? 0) * (float) ($item['price'] ?? 0));
                $subtotal += (float) $item['total'];
            }
            $set("items.{$index}.total", round($item['total'], 2));
        }

        // Get discount and tax percentage
        $discount = (float) ($get('discount') ?? 0);
        $taxPercentage = (float) ($get('tax_percentage') ?? 0);

        // Calculate totals
        $afterDiscount = $subtotal - $discount;
        $taxAmount = ($afterDiscount * $taxPercentage) / 100;
        $total = $afterDiscount + $taxAmount;

        // Set the calculated values
        $set('subtotal', round($subtotal, 2));
        $set('tax_amount', round($taxAmount, 2));
        $set('total', round($total, 2));
    }
}
