<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = 'HR Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Application Details')
                    ->schema([
                        Forms\Components\Select::make('job_id')
                            ->relationship('job', 'title')
                            ->disabled(),
                        Forms\Components\TextInput::make('full_name')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->disabled(),
                        Forms\Components\TextInput::make('portfolio_link')
                            ->label('Portfolio Link')
                            ->url()
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('cover_letter')
                            ->columnSpanFull()
                            ->disabled(),
                        Forms\Components\Placeholder::make('resume_path')
                            ->label('Resume')
                            ->content(fn ($record) => new \Illuminate\Support\HtmlString(
                                "<a href='" . asset('storage/' . $record->resume_path) . "' target='_blank'>Download Resume</a>"
                            )),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'rejected' => 'Rejected',
                                'accepted' => 'Accepted',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job.title')
                    ->searchable()
                    ->sortable()
                    ->action(
                        Tables\Actions\Action::make('view_details_from_title')
                            ->modalHeading(fn ($record) => 'Application Details - ' . $record->full_name)
                            ->modalWidth('7xl')
                            ->modalContent(fn ($record) => view('filament.modals.job-application-details', [
                                'record' => $record->fresh(['job']),
                                'allApplicationIds' => \App\Models\JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray()
                            ]))
                            ->modalCloseButton(true)
                            ->closeModalByClickingAway(false)
                    ),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->action(
                        Tables\Actions\Action::make('view_details_from_name')
                            ->modalHeading(fn ($record) => 'Application Details - ' . $record->full_name)
                            ->modalWidth('7xl')
                            ->modalContent(fn ($record) => view('filament.modals.job-application-details', [
                                'record' => $record->fresh(['job']),
                                'allApplicationIds' => \App\Models\JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray()
                            ]))
                            ->modalCloseButton(true)
                            ->closeModalByClickingAway(false)
                    ),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->action(
                        Tables\Actions\Action::make('view_details_from_email')
                            ->modalHeading(fn ($record) => 'Application Details - ' . $record->full_name)
                            ->modalWidth('7xl')
                            ->modalContent(fn ($record) => view('filament.modals.job-application-details', [
                                'record' => $record->fresh(['job']),
                                'allApplicationIds' => \App\Models\JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray()
                            ]))
                            ->modalCloseButton(true)
                            ->closeModalByClickingAway(false)
                    ),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'info' => 'new',
                        'primary' => 'pending',
                        'danger' => 'rejected',
                        'success' => 'accepted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                        'accepted' => 'Accepted',
                    ]),
                Tables\Filters\SelectFilter::make('job')
                    ->relationship('job', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Update Status')
                    ->form([
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'pending' => 'Pending',
                                'rejected' => 'Rejected',
                                'accepted' => 'Accepted',
                            ])
                            ->required(),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        return ['status' => $data['status']];
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
