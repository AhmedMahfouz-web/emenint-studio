<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class InvoiceStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Invoice Status Distribution';

    protected function getData(): array
    {
        $invoiceStatusData = Invoice::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                $label = match($item->status) {
                    'paid' => 'Paid',
                    'pending' => 'Pending',
                    default => 'Cancelled'
                };
                return [$label => $item->total];
            });

        return [
            'datasets' => [
                [
                    'data' => $invoiceStatusData->values(),
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',  // Green for paid
                        'rgba(251, 191, 36, 0.8)',  // Yellow for pending
                        'rgba(239, 68, 68, 0.8)',   // Red for cancelled
                    ],
                    'borderColor' => [
                        'rgba(34, 197, 94, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $invoiceStatusData->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
