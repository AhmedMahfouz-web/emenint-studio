<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateBlockResource\Pages;
use App\Models\TemplateBlock;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TemplateBlockResource extends Resource
{
    protected static ?string $model = TemplateBlock::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_category_id')
                    ->label('Service Category')
                    ->options(ServiceCategory::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                
                Forms\Components\TextInput::make('block_name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Descriptive name for this template block'),
                
                Forms\Components\Select::make('block_type')
                    ->required()
                    ->options([
                        'hero' => 'Hero',
                        'gallery' => 'Gallery',
                        'description' => 'Description',
                        'challenge_solution' => 'Challenge/Solution',
                        'results' => 'Results',
                        'tech_stack' => 'Tech Stack',
                        'testimonial' => 'Testimonial',
                        'cta' => 'Call to Action',
                    ])
                    ->searchable(),
                
                Forms\Components\Section::make('Template Configuration')
                    ->schema([
                        Forms\Components\Textarea::make('html_template')
                            ->label('HTML Template (Blade)')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull()
                            ->helperText('Use Blade syntax with variables like {{ $variable_name }}'),
                        
                        Forms\Components\Textarea::make('css_styles')
                            ->label('Custom CSS')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Additional CSS styles for this block (optional)'),
                    ]),
                
                Forms\Components\Section::make('Content Schema')
                    ->schema([
                        Forms\Components\KeyValue::make('content_schema')
                            ->label('Form Fields Configuration')
                            ->keyLabel('Field Name')
                            ->valueLabel('Field Configuration (JSON)')
                            ->columnSpanFull()
                            ->helperText('Define the form fields that will appear in the dashboard for this block'),
                        
                        Forms\Components\KeyValue::make('default_content')
                            ->label('Default Content Values')
                            ->keyLabel('Field Name')
                            ->valueLabel('Default Value')
                            ->columnSpanFull()
                            ->helperText('Default values for the form fields'),
                    ]),
                
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
                Tables\Columns\TextColumn::make('block_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('serviceCategory.name')
                    ->label('Category')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('block_type')
                    ->colors([
                        'primary' => 'hero',
                        'success' => 'description',
                        'warning' => 'challenge_solution',
                        'info' => 'gallery',
                        'secondary' => 'cta',
                    ]),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('projects_using_count')
                    ->label('Used in Projects')
                    ->getStateUsing(fn (TemplateBlock $record): int => $record->projectBlockContents()->count()),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_category_id')
                    ->label('Service Category')
                    ->options(ServiceCategory::pluck('name', 'id')),
                
                Tables\Filters\SelectFilter::make('block_type')
                    ->options([
                        'hero' => 'Hero',
                        'gallery' => 'Gallery',
                        'description' => 'Description',
                        'challenge_solution' => 'Challenge/Solution',
                        'results' => 'Results',
                        'tech_stack' => 'Tech Stack',
                        'testimonial' => 'Testimonial',
                        'cta' => 'Call to Action',
                    ]),
                
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
            'index' => Pages\ListTemplateBlocks::route('/'),
            'create' => Pages\CreateTemplateBlock::route('/create'),
            'edit' => Pages\EditTemplateBlock::route('/{record}/edit'),
        ];
    }
}
