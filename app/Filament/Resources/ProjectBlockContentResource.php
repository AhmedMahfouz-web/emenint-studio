<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectBlockContentResource\Pages;
use App\Models\ProjectBlockContent;
use App\Models\Project;
use App\Models\TemplateBlock;
use App\Services\ImageOptimizationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectBlockContentResource extends Resource
{
    protected static ?string $model = ProjectBlockContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Project Blocks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Block Assignment')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->options(Project::pluck('title', 'id'))
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('template_block_id', null)),
                        
                        Forms\Components\Select::make('template_block_id')
                            ->label('Template Block')
                            ->options(function (callable $get) {
                                $projectId = $get('project_id');
                                if (!$projectId) {
                                    return [];
                                }
                                
                                $project = Project::find($projectId);
                                if (!$project) {
                                    return [];
                                }
                                
                                return TemplateBlock::where('service_category_id', $project->service_category_id)
                                    ->where('is_active', true)
                                    ->pluck('block_name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->reactive(),
                        
                        Forms\Components\Toggle::make('is_visible')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Block Content')
                    ->schema([
                        Forms\Components\Builder::make('content_data')
                            ->label('Content Fields')
                            ->blocks([
                                Forms\Components\Builder\Block::make('text')
                                    ->schema([
                                        Forms\Components\TextInput::make('field_name')
                                            ->required(),
                                        Forms\Components\TextInput::make('value')
                                            ->required(),
                                    ]),
                                
                                Forms\Components\Builder\Block::make('textarea')
                                    ->schema([
                                        Forms\Components\TextInput::make('field_name')
                                            ->required(),
                                        Forms\Components\Textarea::make('value')
                                            ->required(),
                                    ]),
                                
                                Forms\Components\Builder\Block::make('image')
                                    ->schema([
                                        Forms\Components\TextInput::make('field_name')
                                            ->required(),
                                        Forms\Components\FileUpload::make('value')
                                            ->label('Image')
                                            ->image()
                                            ->maxSize(51200) // 50MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                                            ->disk('public')
                                            ->directory('projects/images')
                                            ->visibility('public')
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    try {
                                                        $optimized = app(ImageOptimizationService::class)
                                                            ->processUpload($state);
                                                        
                                                        // Store optimization results
                                                        $set('optimized_data', $optimized);
                                                    } catch (\Exception $e) {
                                                        // Handle optimization error gracefully
                                                        logger()->error('Image optimization failed: ' . $e->getMessage());
                                                    }
                                                }
                                            }),
                                        
                                        Forms\Components\Hidden::make('optimized_data'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Custom Styling')
                    ->schema([
                        Forms\Components\Textarea::make('custom_css')
                            ->label('Custom CSS')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Additional CSS styles for this specific block instance'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('templateBlock.block_name')
                    ->label('Block Type')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('templateBlock.block_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'hero',
                        'success' => 'intro',
                        'warning' => 'separator',
                        'info' => 'gallery',
                        'secondary' => 'custom',
                    ]),
                
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Project')
                    ->options(Project::pluck('title', 'id')),
                
                Tables\Filters\TernaryFilter::make('is_visible'),
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
            'index' => Pages\ListProjectBlockContents::route('/'),
            'create' => Pages\CreateProjectBlockContent::route('/create'),
            'edit' => Pages\EditProjectBlockContent::route('/{record}/edit'),
        ];
    }
}
