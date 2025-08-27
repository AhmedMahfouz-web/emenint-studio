<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue Chart';

    protected function getData(): array
    {
        $monthlyRevenueData = Invoice::selectRaw('
            MONTH(invoice_date) as month,
            status,
            SUM(total) as total
        ')
        ->whereYear('invoice_date', Carbon::now()->year)
        ->groupBy('month', 'status')
        ->orderBy('month')
        ->get()
        ->groupBy('month');

        $chartLabels = [];
        $chartDataPaid = [];
        $chartDataPending = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = Carbon::create()->month($month)->format('M');
            
            $monthData = $monthlyRevenueData->get($month, collect());
            $paidTotal = $monthData->where('status', 'paid')->sum('total');
            $pendingTotal = $monthData->where('status', 'pending')->sum('total');
            
            $chartDataPaid[] = $paidTotal;
            $chartDataPending[] = $pendingTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Paid Invoices',
                    'data' => $chartDataPaid,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Pending Invoices',
                    'data' => $chartDataPending,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.2)',
                    'borderColor' => 'rgba(251, 191, 36, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $chartLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
