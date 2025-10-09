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
                Forms\Components\Section::make('Project Image')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->options(Project::pluck('title', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('project-images')
                            ->imagePreviewHeight('300')
                            ->panelAspectRatio('1:1')
                            ->panelLayout('integrated')
                            ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                                $optimizer = app(ImageOptimizationService::class);
                                return $optimizer->optimizeAndConvert($file, 'project-images');
                            })
                            ->helperText('Images will be automatically converted to WebP format'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(fn () => \App\Models\ProjectImage::max('sort_order') + 1)
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->size(150)
                    ->square(),

                Tables\Columns\TextColumn::make('project.title')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),

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
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
