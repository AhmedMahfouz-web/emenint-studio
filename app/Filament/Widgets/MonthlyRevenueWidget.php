<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyRevenueWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $monthlyStats = Invoice::selectRaw('
            SUM(CASE WHEN status = "paid" THEN total ELSE 0 END) as paid_amount,
            SUM(CASE WHEN status = "pending" THEN total ELSE 0 END) as pending_amount,
            currencies.symbol as currency_symbol,
            COUNT(CASE WHEN status = "paid" THEN 1 END) as paid_count,
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count
        ')
        ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
        ->whereYear('invoice_date', Carbon::now()->year)
        ->whereMonth('invoice_date', Carbon::now()->month)
        ->groupBy('currencies.id', 'currencies.symbol')
        ->get();

        $totalPaid = $monthlyStats->sum('paid_amount');
        $totalPending = $monthlyStats->sum('pending_amount');
        $paidCount = $monthlyStats->sum('paid_count');
        $pendingCount = $monthlyStats->sum('pending_count');

        return [
            Stat::make('Monthly Paid Revenue', number_format($totalPaid, 2))
                ->description("{$paidCount} paid invoices this month")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('Monthly Pending Revenue', number_format($totalPending, 2))
                ->description("{$pendingCount} pending invoices this month")
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
