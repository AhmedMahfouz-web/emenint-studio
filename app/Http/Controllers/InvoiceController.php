<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Currency;
use App\Exports\InvoicesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use ZipArchive;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('client');

        // Search by invoice number
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        // Filter by client
        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->latest()->paginate(25);
        $clients = Client::orderBy('name')->get(['id', 'name']);

        return view('back.invoices.index', compact('invoices', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $currencies = Currency::where('is_active', true)->orderBy('name')->get();
        $defaultCurrency = Currency::getDefault();

        return view('back.invoices.create', compact('clients', 'products', 'currencies', 'defaultCurrency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'payment_method' => 'required',
            'first_note' => 'nullable|string',
            'second_note' => 'nullable|string',
            'currency_id' => 'required|exists:currencies,id'
        ]);

        try {
            $invoice = DB::transaction(function () use ($validated, $request) {
                $subtotal = collect($request->items)->sum(function ($item) {
                    return $item['quantity'] * $item['unit_price'];
                });
                $tax_percentage = $validated['tax_percentage'] ?? 0;
                $tax_amount = ($subtotal - $validated['discount']) * ($tax_percentage / 100);
                $total = $subtotal - $validated['discount'] + $tax_amount;

                $invoice = Invoice::create([
                    'client_id' => $validated['client_id'],
                    'payment_method' => $validated['payment_method'],
                    'invoice_date' => $validated['invoice_date'],
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'subtotal' => $subtotal,
                    'discount' => $validated['discount'],
                    'tax_percentage' => $tax_percentage,
                    'tax_amount' => $tax_amount,
                    'total' => $total,
                    'signature' => 'sign.png',
                    'currency_id' => $validated['currency_id'],
                    'first_note' => $validated['first_note'] ?? null,
                    'second_note' => $validated['second_note'] ?? null,
                    'status' => 'pending'
                ]);

                foreach ($request->items as $index => $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $invoice->items()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'price' => $item['unit_price'],
                        'total' => $item['quantity'] * $item['unit_price'],
                    ]);
                }

                return $invoice;
            });

            return redirect()->route('invoices.index')
                ->with('success', 'تم إنشاء الفاتورة بنجاح');
        } catch (\Exception $e) {
            Log::error('Error creating invoice: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items.product']);
        return view('back.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['client', 'items.product']);
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $currencies = Currency::where('is_active', true)->orderBy('name')->get();

        return view('back.invoices.edit', compact('invoice', 'clients', 'products', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'payment_method' => 'required',
            'first_note' => 'nullable|string',
            'second_note' => 'nullable|string',
            'currency_id' => 'required|exists:currencies,id',
            'status' => 'required|in:paid,pending,cancelled'
        ]);

        try {
            DB::transaction(function () use ($invoice, $validated, $request) {
                // Delete existing items
                $invoice->items()->delete();

                // Calculate new subtotal from items
                $subtotal = collect($request->items)->sum(function ($item) {
                    return $item['quantity'] * $item['unit_price'];
                });
                $tax_percentage = $validated['tax_percentage'] ?? 0;
                $tax_amount = ($subtotal - $validated['discount']) * ($tax_percentage / 100);
                $total = $subtotal - $validated['discount'] + $tax_amount;

                // Update invoice
                $invoice->update([
                    'client_id' => $validated['client_id'],
                    'payment_method' => $validated['payment_method'],
                    'invoice_date' => $validated['invoice_date'],
                    'subtotal' => $subtotal,
                    'discount' => $validated['discount'],
                    'tax_percentage' => $tax_percentage,
                    'tax_amount' => $tax_amount,
                    'total' => $total,
                    'signature' => 'sign.png',
                    'currency_id' => $validated['currency_id'],
                    'first_note' => $validated['first_note'] ?? null,
                    'second_note' => $validated['second_note'] ?? null,
                    'status' => $validated['status']
                ]);

                // Create new items
                foreach ($request->items as $item) {
                    $invoice->items()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'price' => $item['unit_price'],
                        'total' => $item['quantity'] * $item['unit_price']
                    ]);
                }
            });

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Download the invoice as a PDF.
     */
    public function download(Invoice $invoice)
    {
        try {
            $invoice->load(['client', 'items.product']);
            return view('back.invoices.pdf', compact('invoice'));
        } catch (\Exception $e) {
            Log::error('Error showing invoice: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while showing the invoice: ' . $e->getMessage());
        }
    }

    /**
     * Bulk download invoices as PDFs.
     */
    public function bulkDownload(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Return view with all invoices to generate PDFs in browser
        $invoices = Invoice::whereBetween('invoice_date', [$request->start_date, $request->end_date])->get();
        return view('back.invoices.bulk-pdf', compact('invoices'));
    }

    /**
     * Export all invoices to an Excel file.
     */
    public function exportExcel()
    {
        return FacadesExcel::download(new InvoicesExport, 'invoices.xlsx');
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateInvoiceNumber()
    {
        $nextId = Invoice::max('id') + 1;
        return now()->format('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
