<?php

namespace App\Filament\Resources\JobApplicationResource\Pages;

use App\Filament\Resources\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Update Status')
                ->modalHeading('Update Application Status')
                ->form([
                    \Filament\Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'rejected' => 'Rejected',
                            'accepted' => 'Accepted',
                        ])
                        ->required(),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    // Only allow status updates, preserve other fields
                    return [
                        'status' => $data['status'],
                    ];
                }),
        ];
    }
}
