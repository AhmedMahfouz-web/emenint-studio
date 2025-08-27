<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceCategoryResource\Pages;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ServiceCategory::class, 'slug', ignoreRecord: true),
                
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
                
                Forms\Components\TextInput::make('icon')
                    ->label('Icon Class')
                    ->placeholder('heroicon-o-star')
                    ->helperText('Enter a Heroicon class name'),

                Forms\Components\TextInput::make('template_name')
                    ->label('Template Name')
                    ->default('default')
                    ->helperText('The name of the Blade view file for projects in this category.'),
                
                Forms\Components\Section::make('Color Scheme')
                    ->schema([
                        Forms\Components\ColorPicker::make('color_scheme.primary')
                            ->label('Primary Color')
                            ->default('#003bf4'),
                        
                        Forms\Components\ColorPicker::make('color_scheme.secondary')
                            ->label('Secondary Color')
                            ->default('#ffffff'),
                        
                        Forms\Components\ColorPicker::make('color_scheme.accent')
                            ->label('Accent Color')
                            ->default('#f8f9fa'),
                    ])
                    ->columns(3),
                
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label('Sort Order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('template_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\ColorColumn::make('color_scheme.primary')
                    ->label('Primary Color'),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('projects_count')
                    ->counts('projects')
                    ->label('Projects'),
                
                Tables\Columns\TextColumn::make('template_blocks_count')
                    ->counts('templateBlocks')
                    ->label('Template Blocks'),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => Pages\ListServiceCategories::route('/'),
            'create' => Pages\CreateServiceCategory::route('/create'),
            'edit' => Pages\EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
