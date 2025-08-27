<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Validate that all item totals are calculated
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                if (!isset($item['total_input']) || $item['total_input'] == 0) {
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
