<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();
            
        return view('back.settings.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.settings.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:currencies',
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $currency = Currency::create($validated);

        if ($request->has('is_default')) {
            $currency->setAsDefault();
        }

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('back.settings.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:currencies,code,' . $currency->id,
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $currency->update($validated);

        if ($request->has('is_default')) {
            $currency->setAsDefault();
        }

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        if ($currency->is_default) {
            return redirect()
                ->route('currencies.index')
                ->with('error', 'Cannot delete the default currency.');
        }

        if ($currency->invoices()->exists() || $currency->products()->exists()) {
            return redirect()
                ->route('currencies.index')
                ->with('error', 'Cannot delete currency that is in use.');
        }

        $currency->delete();

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Currency deleted successfully.');
    }

    public function setDefault(Currency $currency)
    {
        $currency->setAsDefault();

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Default currency updated successfully.');
    }
}
