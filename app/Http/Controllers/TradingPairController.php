<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TradingPair;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TradingPairController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tradingPairs = TradingPair::orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('trading-pairs.index', compact('tradingPairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('trading-pairs.create', [
            'categories' => TradingPair::getCategories(),
            'subcategories' => TradingPair::getSubcategories(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:50|unique:trading_pairs,symbol',
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(TradingPair::getCategories())),
            'subcategory' => 'nullable|string|in:' . implode(',', array_keys(TradingPair::getSubcategories())),
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'decimal_precision' => 'required|integer|min:0|max:8',
        ]);

        TradingPair::create($validated);

        return redirect()->route('trading-pairs.index')
            ->with('success', 'Trading pair created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TradingPair $tradingPair): View
    {
        return view('trading-pairs.show', compact('tradingPair'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TradingPair $tradingPair): View
    {
        return view('trading-pairs.edit', [
            'tradingPair' => $tradingPair,
            'categories' => TradingPair::getCategories(),
            'subcategories' => TradingPair::getSubcategories(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TradingPair $tradingPair): RedirectResponse
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:50|unique:trading_pairs,symbol,' . $tradingPair->id,
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(TradingPair::getCategories())),
            'subcategory' => 'nullable|string|in:' . implode(',', array_keys(TradingPair::getSubcategories())),
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'decimal_precision' => 'required|integer|min:0|max:8',
        ]);

        $tradingPair->update($validated);

        return redirect()->route('trading-pairs.index')
            ->with('success', 'Trading pair updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TradingPair $tradingPair): RedirectResponse
    {
        $tradingPair->delete();

        return redirect()->route('trading-pairs.index')
            ->with('success', 'Trading pair deleted successfully.');
    }

    /**
     * Toggle the active status of a trading pair.
     */
    public function toggleStatus(TradingPair $tradingPair): RedirectResponse
    {
        $tradingPair->update(['is_active' => !$tradingPair->is_active]);

        $status = $tradingPair->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('trading-pairs.index')
            ->with('success', "Trading pair {$status} successfully.");
    }
}
