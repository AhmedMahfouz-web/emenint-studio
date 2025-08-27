<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quotation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Clients', Client::count())
                ->description('All registered clients')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Total Products', Product::count())
                ->description('Available products')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
            
            Stat::make('Total Invoices', Invoice::count())
                ->description('All invoices created')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
            
            Stat::make('Total Quotations', Quotation::count())
                ->description('All quotations created')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('primary'),
        ];
    }
}
