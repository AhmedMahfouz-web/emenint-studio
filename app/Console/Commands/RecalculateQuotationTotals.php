<?php

namespace App\Console\Commands;

use App\Models\Quotation;
use Illuminate\Console\Command;

class RecalculateQuotationTotals extends Command
{
    protected $signature = 'quotations:recalculate-totals';
    protected $description = 'Recalculate totals for all quotations from their items';

    public function handle()
    {
        $this->info('Starting to recalculate quotation totals...');

        $quotations = Quotation::with('items')->get();
        $count = 0;

        foreach ($quotations as $quotation) {
            // Calculate subtotal from items
            $subtotal = $quotation->items->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            });

            $discount = $quotation->discount ?? 0;
            $taxPercentage = $quotation->tax_percentage ?? 0;

            $afterDiscount = $subtotal - $discount;
            $taxAmount = ($afterDiscount * $taxPercentage) / 100;
            $total = $afterDiscount + $taxAmount;

            // Update quotation
            $quotation->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
            ]);

            // Also update item totals
            foreach ($quotation->items as $item) {
                $item->update([
                    'total' => $item->quantity * $item->unit_price,
                ]);
            }

            $count++;
            $this->line("Updated quotation {$quotation->quotation_number}: Total = {$total}");
        }

        $this->info("Successfully recalculated totals for {$count} quotations.");

        return Command::SUCCESS;
    }
}
