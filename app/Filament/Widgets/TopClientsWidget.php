<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopClientsWidget extends BaseWidget
{
    protected static ?string $heading = 'Top Clients';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Client::withCount('invoices')
                    ->withSum(['invoices' => function($query) {
                        $query->where('status', 'paid');
                    }], 'total')
                    ->orderByDesc('invoices_count')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Client Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('Company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoices_count')
                    ->label('Total Invoices')
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoices_sum_total')
                    ->label('Total Revenue')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Client $record): string => "/admin/clients/{$record->id}")
                    ->icon('heroicon-m-eye'),
            ]);
    }
}
