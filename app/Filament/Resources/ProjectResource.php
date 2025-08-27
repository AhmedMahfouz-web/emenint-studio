<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\Select::make('service_category_id')
                            ->label('Service Category')
                            ->options(ServiceCategory::where('is_active', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Project::class, 'slug', ignoreRecord: true),
                        
                        Forms\Components\Textarea::make('short_description')
                            ->label('Short Description')
                            ->columnSpanFull()
                            ->rows(2),
                        
                        Forms\Components\TextInput::make('client_name')
                            ->maxLength(255),
                        
                        Forms\Components\DatePicker::make('project_date'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Project'),
                        
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Project Details')
                    ->schema([
                        Forms\Components\RichEditor::make('project_summary')->columnSpanFull(),
                        Forms\Components\RichEditor::make('challenge')->columnSpanFull(),
                        Forms\Components\RichEditor::make('solution')->columnSpanFull(),
                        Forms\Components\RichEditor::make('results')->columnSpanFull(),
                        Forms\Components\TagsInput::make('services_provided')->columnSpan(1),
                        Forms\Components\TagsInput::make('technologies_used')->columnSpan(1),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('project-images'),
                        Forms\Components\FileUpload::make('gallery_images')
                            ->image()
                            ->multiple()
                            ->directory('project-images/gallery'),
                    ])->columns(2),

                Forms\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Forms\Components\Section::make('Content Blocks')
                    ->schema([
                        Forms\Components\Repeater::make('blockContents')
                            ->relationship()
                            ->label('Project Content Blocks')
                            ->schema([
                                Forms\Components\Select::make('template_block_id')
                                    ->label('Block Type')
                                    ->options(\App\Models\TemplateBlock::pluck('block_name', 'id'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn (callable $set) => $set('content_data', [])),

                                Forms\Components\Grid::make(1)
                                    ->schema(function (callable $get) {
                                        $templateBlockId = $get('template_block_id');
                                        if (!$templateBlockId) {
                                            return [];
                                        }

                                        $templateBlock = \App\Models\TemplateBlock::find($templateBlockId);
                                        if (!$templateBlock || !is_array($templateBlock->content_schema)) {
                                            return [];
                                        }

                                        $fields = [];
                                        foreach ($templateBlock->content_schema as $fieldName => $fieldConfig) {
                                            $field = null;
                                            $type = $fieldConfig['type'] ?? 'text';
                                            $label = $fieldConfig['label'] ?? ucfirst(str_replace('_', ' ', $fieldName));
                                            $required = $fieldConfig['required'] ?? false;

                                            switch ($type) {
                                                case 'textarea':
                                                    $field = Forms\Components\Textarea::make('content_data.' . $fieldName)->label($label);
                                                    break;
                                                case 'rich_editor':
                                                    $field = Forms\Components\RichEditor::make('content_data.' . $fieldName)->label($label);
                                                    break;
                                                case 'file_upload':
                                                    $field = Forms\Components\FileUpload::make('content_data.' . $fieldName)->label($label);
                                                    break;
                                                case 'toggle':
                                                    $field = Forms\Components\Toggle::make('content_data.' . $fieldName)->label($label);
                                                    break;
                                                default:
                                                    $field = Forms\Components\TextInput::make('content_data.' . $fieldName)->label($label);
                                            }

                                            if ($required) {
                                                $field->required();
                                            }
                                            $fields[] = $field;
                                        }
                                        return $fields;
                                    }),

                                Forms\Components\Textarea::make('custom_css')->rows(3)->columnSpanFull(),
                                Forms\Components\Toggle::make('is_visible')->default(true)->columnSpanFull(),
                            ])
                            ->orderColumn('sort_order')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->label('Image'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('serviceCategory.name')
                    ->label('Category')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'active',
                        'warning' => 'archived',
                    ]),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                
                Tables\Columns\TextColumn::make('blockContents_count')
                    ->counts('blockContents')
                    ->label('Blocks'),
                
                Tables\Columns\TextColumn::make('project_date')
                    ->date()
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
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'archived' => 'Archived',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_featured'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
