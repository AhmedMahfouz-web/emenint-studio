<?php

namespace App\Filament\Resources\ProjectImageResource\Pages;

use App\Filament\Resources\ProjectImageResource;
use App\Models\Project;
use App\Models\ProjectImage;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class ManageGallery extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProjectImageResource::class;

    protected static string $view = 'filament.resources.project-image-resource.pages.manage-gallery';

    protected static ?string $title = 'Gallery Manager';

    protected static ?string $navigationLabel = 'Gallery Manager';

    public ?int $selectedProject = null;

    public function mount(): void
    {
        $this->selectedProject = request()->get('project');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(ProjectImage::class)
                ->form([
                    Forms\Components\Select::make('project_id')
                        ->label('Project')
                        ->options(Project::pluck('title', 'id'))
                        ->default($this->selectedProject)
                        ->required()
                        ->searchable(),
                    
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Images')
                        ->image()
                        ->multiple()
                        ->required()
                        ->disk('public')
                        ->directory('project-images'),
                        
                    Forms\Components\TextInput::make('alt_text')
                        ->label('Alt Text Template')
                        ->helperText('Will be used for all uploaded images'),
                ])
                ->action(function (array $data) {
                    $sortOrder = ProjectImage::where('project_id', $data['project_id'])->max('sort_order') + 1;
                    
                    foreach ($data['image_path'] as $imagePath) {
                        ProjectImage::create([
                            'project_id' => $data['project_id'],
                            'image_path' => $imagePath,
                            'alt_text' => $data['alt_text'] ?? 'Project Image',
                            'sort_order' => $sortOrder++,
                        ]);
                    }
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProjectImage::query()
                    ->with('project')
                    ->when($this->selectedProject, fn (Builder $query) => $query->where('project_id', $this->selectedProject))
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('')
                    ->disk('public')
                    ->size(150)
                    ->square(),
                    
                Tables\Columns\TextColumn::make('project.title')
                    ->label('Project')
                    ->weight('bold')
                    ->toggleable(isToggledHiddenByDefault: !$this->selectedProject),
                    
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt Text')
                    ->limit(30)
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('★')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Project')
                    ->options(Project::pluck('title', 'id'))
                    ->default($this->selectedProject),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Image'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete Image'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->striped(false)
            ->paginated([12, 24, 48]);
    }
}
