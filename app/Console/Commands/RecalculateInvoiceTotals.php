<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class RecalculateInvoiceTotals extends Command
{
    protected $signature = 'invoices:recalculate-totals';
    protected $description = 'Recalculate totals for all invoices from their items';

    public function handle()
    {
        $this->info('Starting to recalculate invoice totals...');

        $invoices = Invoice::with('items')->get();
        $count = 0;

        foreach ($invoices as $invoice) {
            // Calculate subtotal from items
            $subtotal = $invoice->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $discount = $invoice->discount ?? 0;
            $taxPercentage = $invoice->tax_percentage ?? 0;

            $afterDiscount = $subtotal - $discount;
            $taxAmount = ($afterDiscount * $taxPercentage) / 100;
            $total = $afterDiscount + $taxAmount;

            // Update invoice
            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
            ]);

            // Also update item totals
            foreach ($invoice->items as $item) {
                $item->update([
                    'total' => $item->quantity * $item->price,
                ]);
            }

            $count++;
            $this->line("Updated invoice {$invoice->invoice_number}: Total = {$total}");
        }

        $this->info("Successfully recalculated totals for {$count} invoices.");

        return Command::SUCCESS;
    }
}
