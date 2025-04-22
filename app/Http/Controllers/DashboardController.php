<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalQuotations = Quotation::count();
        $totalInvoices = Invoice::count();

        // Monthly Revenue Statistics
        $monthlyStats = Invoice::selectRaw('
            SUM(CASE WHEN status = "paid" THEN total ELSE 0 END) as paid_amount,
            SUM(CASE WHEN status = "pending" THEN total ELSE 0 END) as pending_amount,
            currencies.code as currency_code,
            currencies.symbol as currency_symbol,
            COUNT(CASE WHEN status = "paid" THEN 1 END) as paid_count,
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count
        ')
        ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
        ->whereYear('invoice_date', Carbon::now()->year)
        ->whereMonth('invoice_date', Carbon::now()->month)
        ->groupBy('currencies.id', 'currencies.code', 'currencies.symbol')
        ->get();

        $monthlyRevenue = [
            'paid' => $monthlyStats->map(function($stat) {
                return [
                    'amount' => $stat->paid_amount,
                    'currency' => $stat->currency_symbol,
                    'count' => $stat->paid_count
                ];
            })->filter(function($item) {
                return $item['count'] > 0;
            })->values(),
            'pending' => $monthlyStats->map(function($stat) {
                return [
                    'amount' => $stat->pending_amount,
                    'currency' => $stat->currency_symbol,
                    'count' => $stat->pending_count
                ];
            })->filter(function($item) {
                return $item['count'] > 0;
            })->values()
        ];

        // Yearly Revenue Statistics
        $yearlyStats = Invoice::selectRaw('
            SUM(CASE WHEN status = "paid" THEN total ELSE 0 END) as paid_amount,
            SUM(CASE WHEN status = "pending" THEN total ELSE 0 END) as pending_amount,
            currencies.code as currency_code,
            currencies.symbol as currency_symbol,
            COUNT(CASE WHEN status = "paid" THEN 1 END) as paid_count,
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count
        ')
        ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
        ->whereYear('invoice_date', Carbon::now()->year)
        ->groupBy('currencies.id', 'currencies.code', 'currencies.symbol')
        ->get();

        $yearlyRevenue = [
            'paid' => $yearlyStats->map(function($stat) {
                return [
                    'amount' => $stat->paid_amount,
                    'currency' => $stat->currency_symbol,
                    'count' => $stat->paid_count
                ];
            })->filter(function($item) {
                return $item['count'] > 0;
            })->values(),
            'pending' => $yearlyStats->map(function($stat) {
                return [
                    'amount' => $stat->pending_amount,
                    'currency' => $stat->currency_symbol,
                    'count' => $stat->pending_count
                ];
            })->filter(function($item) {
                return $item['count'] > 0;
            })->values()
        ];

        // Monthly Revenue Chart Data
        $monthlyRevenueData = Invoice::selectRaw('
            MONTH(invoice_date) as month,
            status,
            currencies.code as currency_code,
            currencies.symbol as currency_symbol,
            SUM(total) as total
        ')
        ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
        ->whereYear('invoice_date', Carbon::now()->year)
        ->groupBy('month', 'status', 'currencies.id', 'currencies.code', 'currencies.symbol')
        ->orderBy('month')
        ->get()
        ->groupBy('month')
        ->map(function($monthData) {
            return [
                'paid' => $monthData->where('status', 'paid')->groupBy('currencies.id')
                    ->map(function($curr) {
                        return ['amount' => $curr->sum('total'), 'currency' => $curr->first()->currency_symbol];
                    })->values(),
                'pending' => $monthData->where('status', 'pending')->groupBy('currencies.id')
                    ->map(function($curr) {
                        return ['amount' => $curr->sum('total'), 'currency' => $curr->first()->currency_symbol];
                    })->values()
            ];
        });

        // Format chart data for JavaScript
        $chartLabels = [];
        $chartDataPaid = [];
        $chartDataPending = [];
        
        foreach($monthlyRevenueData as $month => $data) {
            $chartLabels[] = Carbon::create()->month($month)->format('F');
            
            // Sum up all currencies for paid invoices
            $totalPaid = 0;
            foreach($data['paid'] as $curr) {
                // You might want to add currency conversion here
                $totalPaid += $curr['amount'];
            }
            $chartDataPaid[] = $totalPaid;
            
            // Sum up all currencies for pending invoices
            $totalPending = 0;
            foreach($data['pending'] as $curr) {
                // You might want to add currency conversion here
                $totalPending += $curr['amount'];
            }
            $chartDataPending[] = $totalPending;
        }

        $chartData = [
            'labels' => $chartLabels,
            'datasets' => [
                [
                    'label' => 'Paid Invoices',
                    'data' => $chartDataPaid,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Pending Invoices',
                    'data' => $chartDataPending,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        // Recent Invoices
        $recentInvoices = Invoice::with(['client', 'currency'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Quotations
        $recentQuotations = Quotation::with(['client', 'currency'])
            ->latest()
            ->take(5)
            ->get();

        // Top Clients
        $topClients = Client::withCount('invoices')
            ->withSum(['invoices' => function($query) {
                $query->where('status', 'paid');
            }], 'total')
            ->orderByDesc('invoices_count')
            ->take(5)
            ->get();

        // Invoice Status Distribution
        $invoiceStatusData = Invoice::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                $label = match($item->status) {
                    'paid' => 'مدفوعة',
                    'pending' => 'قيد الانتظار',
                    default => 'ملغاة'
                };
                return [$label => $item->total];
            });

        $invoiceStatusChart = [
            'labels' => $invoiceStatusData->keys(),
            'datasets' => [[
                'data' => $invoiceStatusData->values(),
                'backgroundColor' => [
                    'rgba(75, 192, 192, 0.2)',  // Green for paid
                    'rgba(255, 206, 86, 0.2)',  // Yellow for pending
                    'rgba(255, 99, 132, 0.2)',  // Red for cancelled
                ],
                'borderColor' => [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                'borderWidth' => 1
            ]]
        ];

        // Quotation Status Distribution
        $quotationStatusDistribution = Quotation::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('back.dashboard', compact(
            'totalClients',
            'totalProducts',
            'totalQuotations',
            'totalInvoices',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentInvoices',
            'recentQuotations',
            'chartData',
            'topClients',
            'invoiceStatusChart',
            'quotationStatusDistribution'
        ));
    }
}
