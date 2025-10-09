<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectImageResource\Pages;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Services\ImageOptimizationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;

class ProjectImageResource extends Resource
{
    protected static ?string $model = ProjectImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Project Images';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project & Image')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->options(Project::pluck('title', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Image')
                                    ->image()
                                    ->required()
                                    ->disk('public')
                                    ->directory('project-images')
                                    ->imagePreviewHeight('200')
                                    ->panelAspectRatio('16:9')
                                    ->panelLayout('integrated')
                                    ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                                        $optimizer = app(ImageOptimizationService::class);
                                        return $optimizer->optimizeAndConvert($file, 'project-images');
                                    })
                                    ->helperText('Images will be automatically converted to WebP format'),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Image Details')
                    ->schema([
                        Forms\Components\TextInput::make('alt_text')
                            ->label('Alt Text')
                            ->maxLength(255)
                            ->placeholder('Describe the image for accessibility')
                            ->helperText('Important for SEO and accessibility')
                            ->columnSpan(2),

                        Forms\Components\Textarea::make('caption')
                            ->label('Caption')
                            ->rows(3)
                            ->placeholder('Optional caption to display with the image')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(fn () => \App\Models\ProjectImage::max('sort_order') + 1)
                            ->helperText('Lower numbers appear first')
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Image')
                            ->helperText('Highlight this image in the gallery')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->size(120)
                    ->square(),

                Tables\Columns\TextColumn::make('project.title')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt Text')
                    ->limit(40)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(50)
                    ->searchable()
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Project')
                    ->options(Project::pluck('title', 'id')),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('toggle_featured')
                    ->label('Toggle Featured')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->iconButton()
                    ->action(function ($record) {
                        $record->update(['is_featured' => !$record->is_featured]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_featured')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => true]);
                        }),
                    Tables\Actions\BulkAction::make('unmark_featured')
                        ->label('Remove Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each->update(['is_featured' => false]);
                        }),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->paginated([10, 25, 50]);
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
            'index' => Pages\ListProjectImages::route('/'),
            'create' => Pages\CreateProjectImage::route('/create'),
            'edit' => Pages\EditProjectImage::route('/{record}/edit'),
            'gallery' => Pages\ManageGallery::route('/gallery'),
        ];
    }
}
