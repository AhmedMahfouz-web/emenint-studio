<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('createFromInvoice')
                ->label('Create from Invoice')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->form([
                    \Filament\Forms\Components\Select::make('invoice_id')
                        ->label('Select Invoice')
                        ->options(\App\Models\Invoice::with('client')
                            ->get()
                            ->mapWithKeys(fn($i) => [$i->id => "{$i->invoice_number} - {$i->client->name} ({$i->currency->symbol}{$i->total})"]))
                        ->required()
                        ->searchable()
                        ->helperText('Select an invoice to convert into a quotation'),
                ])
                ->action(function (array $data) {
                    $invoice = \App\Models\Invoice::with('items')->findOrFail($data['invoice_id']);
                    
                    // Create new quotation from invoice
                    $quotation = \App\Models\Quotation::create([
                        'client_id' => $invoice->client_id,
                        'quotation_number' => 'QUO-' . str_pad((\App\Models\Quotation::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
                        'quotation_date' => now(),
                        'subtotal' => $invoice->subtotal,
                        'discount' => $invoice->discount,
                        'tax_percentage' => $invoice->tax_percentage,
                        'tax_amount' => $invoice->tax_amount,
                        'total' => $invoice->total,
                        'signature' => $invoice->signature,
                        'first_note' => $invoice->first_note,
                        'second_note' => $invoice->second_note,
                        'status' => 'pending',
                        'currency_id' => $invoice->currency_id,
                    ]);

                    // Copy invoice items to quotation items
                    foreach ($invoice->items as $item) {
                        \App\Models\QuotationItem::create([
                            'quotation_id' => $quotation->id,
                            'product_id' => $item->product_id ?? null,
                            'description' => $item->description ?? '',
                            'quantity' => $item->quantity ?? 1,
                            'unit_price' => $item->price ?? 0,
                            'total' => $item->total ?? 0,
                        ]);
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Quotation Created')
                        ->success()
                        ->body("Quotation {$quotation->quotation_number} has been created from invoice {$invoice->invoice_number}.")
                        ->send();

                    return redirect()->route('filament.admin.resources.quotations.edit', ['record' => $quotation->id]);
                }),
        ];
    }
}
