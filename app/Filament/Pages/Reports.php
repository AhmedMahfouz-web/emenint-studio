<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use App\Models\Client;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.reports';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->endOfMonth(),
            'client_id' => null,
            'status' => 'all',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->required()
                    ->default(now()->startOfMonth()),
                DatePicker::make('end_date')
                    ->required()
                    ->default(now()->endOfMonth()),
                Select::make('client_id')
                    ->label('Client')
                    ->options(Client::all()->pluck('name', 'id'))
                    ->placeholder('All Clients'),
                Select::make('status')
                    ->options([
                        'all' => 'All Statuses',
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('all'),
            ])
            ->columns(4)
            ->statePath('data');
    }

    public function generateReport(): void
    {
        $data = $this->form->getState();
        
        $query = Invoice::with(['client', 'currency'])
            ->whereBetween('invoice_date', [$data['start_date'], $data['end_date']]);

        if ($data['client_id']) {
            $query->where('client_id', $data['client_id']);
        }

        if ($data['status'] !== 'all') {
            $query->where('status', $data['status']);
        }

        $invoices = $query->get();
        
        // Store results for display
        $this->data['results'] = $invoices;
        $this->data['summary'] = [
            'total_invoices' => $invoices->count(),
            'total_amount' => $invoices->sum('total'),
            'paid_amount' => $invoices->where('status', 'paid')->sum('total'),
            'pending_amount' => $invoices->where('status', 'pending')->sum('total'),
        ];

        Notification::make()
            ->title('Report generated successfully')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Report')
                ->action('generateReport')
                ->color('primary'),
        ];
    }
}
