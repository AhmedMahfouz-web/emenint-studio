<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Client;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with('client');

        // Search by quotation number
        if ($request->filled('search')) {
            $query->where('quotation_number', 'like', '%' . $request->search . '%');
        }

        // Filter by client
        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('quotation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('quotation_date', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quotations = $query->latest()->paginate(25);
        $clients = Client::orderBy('name')->get(['id', 'name']);

        return view('back.quotations.index', compact('quotations', 'clients'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $currencies = Currency::all();
        return view('back.quotations.create', compact('clients', 'products', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quotation_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'first_note' => 'nullable|string',
            'second_note' => 'nullable|string',
            'currency_id' => 'required|exists:currencies,id',
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                // Calculate subtotal
                $subtotal = collect($request->items)->sum(function ($item) {
                    return $item['quantity'] * $item['unit_price'];
                });

                $tax_percentage = $validated['tax_percentage'] ?? 0;
                $tax_amount = ($subtotal - $validated['discount']) * ($tax_percentage / 100);
                $total = $subtotal - $validated['discount'] + $tax_amount;

                // Create quotation
                $quotation = Quotation::create([
                    'client_id' => $validated['client_id'],
                    'quotation_date' => $validated['quotation_date'],
                    'quotation_number' => $this->generateQuotationNumber(),
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

                // Create items
                foreach ($request->items as $item) {
                    $quotation->items()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'price' => $item['unit_price'],
                        'total' => $item['quantity'] * $item['unit_price']
                    ]);
                }
            });

            return redirect()
                ->route('quotations.index')
                ->with('success', 'تم إنشاء عرض السعر بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'فشل في إنشاء عرض السعر: ' . $e->getMessage());
        }
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['client', 'items.product', 'currency']);
        return view('back.quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $quotation->load(['client', 'items.product', 'currency']);
        $clients = Client::all();
        $products = Product::all();
        $currencies = Currency::all();
        return view('back.quotations.edit', compact('quotation', 'clients', 'products', 'currencies'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quotation_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'first_note' => 'nullable|string',
            'second_note' => 'nullable|string',
            'currency_id' => 'required|exists:currencies,id',
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        try {
            DB::transaction(function () use ($validated, $request, $quotation) {
                // Calculate subtotal
                $subtotal = collect($request->items)->sum(function ($item) {
                    return $item['quantity'] * $item['unit_price'];
                });

                $tax_percentage = $validated['tax_percentage'] ?? 0;
                $tax_amount = ($subtotal - $validated['discount']) * ($tax_percentage / 100);
                $total = $subtotal - $validated['discount'] + $tax_amount;

                // Update quotation
                $quotation->update([
                    'client_id' => $validated['client_id'],
                    'quotation_date' => $validated['quotation_date'],
                    'subtotal' => $subtotal,
                    'discount' => $validated['discount'],
                    'tax_percentage' => $tax_percentage,
                    'tax_amount' => $tax_amount,
                    'total' => $total,
                    'currency_id' => $validated['currency_id'],
                    'first_note' => $validated['first_note'] ?? null,
                    'second_note' => $validated['second_note'] ?? null,
                    'status' => $validated['status']
                ]);

                // Delete old items
                $quotation->items()->delete();

                // Create new items
                foreach ($request->items as $item) {
                    $quotation->items()->create([
                        'product_id' => $item['product_id'],
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'price' => $item['unit_price'],
                        'total' => $item['quantity'] * $item['unit_price']
                    ]);
                }
            });

            return redirect()
                ->route('quotations.index')
                ->with('success', 'تم تحديث عرض السعر بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'فشل في تحديث عرض السعر: ' . $e->getMessage());
        }
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')
            ->with('success', 'تم حذف عرض السعر بنجاح');
    }

    /**
     * Download the quotation as PDF
     */
    public function download(Quotation $quotation)
    {
        try {
            $quotation->load(['client', 'items', 'currency']);
            return view('back.quotations.pdf', compact('quotation'));
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while generating the PDF: ' . $e->getMessage());
        }
    }
}
