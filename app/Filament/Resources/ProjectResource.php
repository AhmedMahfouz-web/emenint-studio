<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Services\ImageOptimizationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

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
                            ->afterStateUpdated(fn(string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

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
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('project-images')
                            ->visibility('public')
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->helperText('Upload a featured image for this project. Will be automatically optimized to WebP format.')
                            ->multiple(false) // Explicitly single file
                            ->nullable()
                            ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                                try {
                                    $optimizer = app(ImageOptimizationService::class);
                                    // Optimize and convert to WebP format
                                    return $optimizer->optimizeAndConvert($file, 'project-images', 1920, 1080, 85);
                                } catch (\Exception $e) {
                                    Log::error('Featured image optimization failed: ' . $e->getMessage());
                                    // Fallback to normal upload
                                    $filename = time() . '_' . $file->hashName();
                                    return $file->storeAs('project-images', $filename, 'public');
                                }
                            }),

                    ])->columns(2),

                Forms\Components\Section::make('Project Images')
                    ->schema([
                        Forms\Components\Placeholder::make('gallery_info')
                            ->label('')
                            ->content('Upload project images. Use the "Bulk Upload Images" button below to upload multiple images at once, or add them individually below.')
                            ->columnSpanFull()
                            ->visible(fn($context) => $context === 'create'),

                        Forms\Components\Placeholder::make('gallery_info_edit')
                            ->label('')
                            ->content('<strong>Upload project images.</strong> Use the "Bulk Upload Images" button below to upload multiple images at once, or add them individually below.')
                            ->columnSpanFull()
                            ->visible(fn($context) => $context === 'edit'),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('bulk_upload')
                                ->label('Bulk Upload Images')
                                ->icon('heroicon-o-arrow-up-tray')
                                ->color('primary')
                                ->action('openBulkUploadModal')
                                ->visible(fn($context) => in_array($context, ['create', 'edit'])),
                        ])->visible(fn($context) => in_array($context, ['create', 'edit']))
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'mb-4']),

                        Forms\Components\Repeater::make('projectImages')
                            ->relationship()
                            ->label('Project Images')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('')
                                    ->image()
                                    ->required()
                                    ->disk('public')
                                    ->directory('project-images')
                                    ->imagePreviewHeight('120')
                                    ->panelAspectRatio('1:1')
                                    ->panelLayout('integrated')
                                    ->visibility('public')
                                    ->maxSize(10240) // 10MB
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->multiple(false)
                                    ->nullable()
                                    ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                                        try {
                                            $optimizer = app(ImageOptimizationService::class);
                                            // Optimize and convert to WebP format
                                            return $optimizer->optimizeAndConvert($file, 'project-images', 1920, 1920, 80);
                                        } catch (\Exception $e) {
                                            Log::error('Gallery image optimization failed: ' . $e->getMessage());
                                            // Fallback to normal upload
                                            $filename = time() . '_' . $file->hashName();
                                            return $file->storeAs('project-images', $filename, 'public');
                                        }
                                    })
                            ])
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->addActionLabel('Add Another Image')
                            ->deleteAction(
                                fn(Forms\Components\Actions\Action $action) => $action
                                    ->requiresConfirmation()
                                    ->modalDescription('Delete this image?')
                                    ->modalSubmitActionLabel('Delete')
                                    ->color('danger')
                                    ->size('sm')
                                    ->modalWidth('sm')
                            )
                            ->collapsed()
                            ->columnSpanFull()
                            ->grid([
                                'default' => 3,
                                'sm' => 4,
                                'md' => 5,
                                'lg' => 6,
                                'xl' => 8,
                            ])
                            ->defaultItems(1)
                            ->cloneable(false)
                            ->visible(fn($context) => in_array($context, ['create', 'edit'])),
                    ])
                    ->collapsible(),

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

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public')
                    ->size(60),

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
