<?php

namespace App\Filament\Resources\JobResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'applications';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel(),
                Forms\Components\Textarea::make('cover_letter')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                        'accepted' => 'Accepted',
                    ])
                    ->required(),
                Forms\Components\Placeholder::make('resume_path')
                    ->label('Resume')
                    ->content(fn ($record) => new \Illuminate\Support\HtmlString(
                        "<a href='" . asset('storage/' . $record->resume_path) . "' target='_blank'>Download Resume</a>"
                    ))
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'info' => 'new',
                        'primary' => 'pending',
                        'danger' => 'rejected',
                        'success' => 'accepted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
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
            ])
            ->headerActions([
                // No create action needed here, applications come from the frontend
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalHeading(fn ($record) => 'Application Details - ' . $record->full_name)
                    ->modalWidth('7xl')
                    ->modalContent(fn ($record) => view('filament.modals.job-application-details', [
                        'record' => $record->fresh(['job']),
                        'allApplicationIds' => \App\Models\JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray()
                    ]))
                    ->modalCloseButton(true)
                    ->closeModalByClickingAway(false),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
