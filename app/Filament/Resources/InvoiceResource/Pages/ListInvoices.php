<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('createFromQuotation')
                ->label('Create from Quotation')
                ->icon('heroicon-o-document-duplicate')
                ->color('info')
                ->form([
                    \Filament\Forms\Components\Select::make('quotation_id')
                        ->label('Select Quotation')
                        ->options(\App\Models\Quotation::with('client')
                            ->get()
                            ->mapWithKeys(fn($q) => [$q->id => "{$q->quotation_number} - {$q->client->name} ({$q->currency->symbol}{$q->total})"]))
                        ->required()
                        ->searchable()
                        ->helperText('Select a quotation to convert into an invoice'),
                ])
                ->action(function (array $data) {
                    $quotation = \App\Models\Quotation::with('items')->findOrFail($data['quotation_id']);
                    
                    // Create new invoice from quotation
                    $invoice = \App\Models\Invoice::create([
                        'client_id' => $quotation->client_id,
                        'invoice_number' => 'INV-' . str_pad((\App\Models\Invoice::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
                        'invoice_date' => now(),
                        'payment_method' => 'cash',
                        'subtotal' => $quotation->subtotal,
                        'discount' => $quotation->discount,
                        'tax_percentage' => $quotation->tax_percentage,
                        'tax_amount' => $quotation->tax_amount,
                        'total' => $quotation->total,
                        'signature' => $quotation->signature,
                        'first_note' => $quotation->first_note,
                        'second_note' => $quotation->second_note,
                        'status' => 'pending',
                        'currency_id' => $quotation->currency_id,
                    ]);

                    // Copy quotation items to invoice items
                    foreach ($quotation->items as $item) {
                        \App\Models\InvoiceItem::create([
                            'invoice_id' => $invoice->id,
                            'product_id' => $item->product_id ?? null,
                            'description' => $item->description ?? '',
                            'quantity' => $item->quantity ?? 1,
                            'price' => $item->unit_price ?? 0,
                            'total' => $item->total ?? 0,
                        ]);
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Invoice Created')
                        ->success()
                        ->body("Invoice {$invoice->invoice_number} has been created from quotation {$quotation->quotation_number}.")
                        ->send();

                    return redirect()->route('filament.admin.resources.invoices.edit', ['record' => $invoice->id]);
                }),
        ];
    }
}
