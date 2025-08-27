<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validate that all item totals are calculated
        if (isset($data['items'])) {
            foreach ($data['items'] as $index => $item) {
                $item['total'] = $item['quantity'] * $item['unit_price'];
                if (!isset($item['total']) || $item['total'] == 0) {
                    if (isset($item['quantity']) && isset($item['unit_price'])) {
                        Notification::make()
                            ->title('Calculation Error')
                            ->body('Please ensure all item totals are calculated before submitting.')
                            ->danger()
                            ->send();
                        $this->halt();
                    }
                }
            }
        }

        // Calculate totals
        $subtotal = collect($data['items'] ?? [])->sum('total');
        $discount = $data['discount'] ?? 0;
        $taxPercentage = $data['tax_percentage'] ?? 0;

        $afterDiscount = $subtotal - $discount;
        $taxAmount = ($afterDiscount * $taxPercentage) / 100;
        $total = $afterDiscount + $taxAmount;

        $data['subtotal'] = $subtotal;
        $data['tax_amount'] = $taxAmount;
        $data['total'] = $total;

        return $data;
    }
}
