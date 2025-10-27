<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TradePlan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TradePlanController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Auth::user()->tradePlans();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by trade result
        if ($request->filled('trade_result')) {
            $query->where('trade_result', $request->trade_result);
        }

        // Filter by trading pair
        if ($request->filled('trading_pair')) {
            $query->where('trading_pair', 'like', '%' . $request->trading_pair . '%');
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $tradePlans = $query->paginate(15);

        return view('trade-plans.index', compact('tradePlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('trade-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'trading_pair' => 'required|string|max:50',
            'custom_pair' => 'nullable|string|max:50',
            'strategy' => 'nullable|in:' . implode(',', array_keys(TradePlan::getStrategies())),
            'pattern_type' => 'nullable|in:' . implode(',', array_keys(TradePlan::getPatternTypes())),
            'status' => 'required|in:' . implode(',', array_keys(TradePlan::getStatuses())),
            'entry_price' => 'nullable|numeric|min:0',
            'exit_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
            'take_profit' => 'nullable|numeric|min:0',
            'trade_type' => 'nullable|in:' . implode(',', array_keys(TradePlan::getTradeTypes())),
            'position_size' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'chart_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'planned_entry_time' => 'nullable|date',
            'planned_exit_time' => 'nullable|date',
            'risk_reward_ratio' => 'nullable|numeric|min:0',
            'risk_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle custom trading pair
        if ($validated['trading_pair'] === 'CUSTOM' && !empty($validated['custom_pair'])) {
            $validated['trading_pair'] = $validated['custom_pair'];
        }
        unset($validated['custom_pair']);

        // Handle chart image upload
        if ($request->hasFile('chart_image')) {
            $file = $request->file('chart_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('charts', $filename, 'public');
            $validated['chart_image'] = $filename;
        }

        $validated['user_id'] = Auth::id();

        TradePlan::create($validated);

        return redirect()->route('trade-plans.index')
            ->with('success', 'Trade plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TradePlan $tradePlan): View
    {
        $this->authorize('view', $tradePlan);
        
        return view('trade-plans.show', compact('tradePlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TradePlan $tradePlan): View
    {
        $this->authorize('update', $tradePlan);
        
        return view('trade-plans.edit', compact('tradePlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TradePlan $tradePlan): RedirectResponse
    {
        $this->authorize('update', $tradePlan);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'trading_pair' => 'required|string|max:50',
            'strategy' => 'nullable|in:' . implode(',', array_keys(TradePlan::getStrategies())),
            'pattern_type' => 'nullable|in:' . implode(',', array_keys(TradePlan::getPatternTypes())),
            'status' => 'required|in:' . implode(',', array_keys(TradePlan::getStatuses())),
            'entry_price' => 'nullable|numeric|min:0',
            'exit_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
            'take_profit' => 'nullable|numeric|min:0',
            'trade_type' => 'nullable|in:' . implode(',', array_keys(TradePlan::getTradeTypes())),
            'position_size' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'chart_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'planned_entry_time' => 'nullable|date',
            'planned_exit_time' => 'nullable|date',
            'actual_entry_time' => 'nullable|date',
            'actual_exit_time' => 'nullable|date',
            'risk_reward_ratio' => 'nullable|numeric|min:0',
            'risk_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle chart image upload
        if ($request->hasFile('chart_image')) {
            // Delete old image if exists
            if ($tradePlan->chart_image && Storage::disk('public')->exists('charts/' . $tradePlan->chart_image)) {
                Storage::disk('public')->delete('charts/' . $tradePlan->chart_image);
            }
            
            $file = $request->file('chart_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('charts', $filename, 'public');
            $validated['chart_image'] = $filename;
        }

        $tradePlan->update($validated);

        return redirect()->route('trade-plans.index')
            ->with('success', 'Trade plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TradePlan $tradePlan): RedirectResponse
    {
        $this->authorize('delete', $tradePlan);
        
        $tradePlan->delete();

        return redirect()->route('trade-plans.index')
            ->with('success', 'Trade plan deleted successfully.');
    }

    /**
     * Update the status of a trade plan.
     */
    public function updateStatus(Request $request, TradePlan $tradePlan): RedirectResponse
    {
        $this->authorize('update', $tradePlan);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(TradePlan::getStatuses())),
        ]);

        $tradePlan->update($validated);

        return redirect()->back()
            ->with('success', 'Trade plan status updated successfully.');
    }

    /**
     * Update the trade result of a trade plan.
     */
    public function updateResult(Request $request, TradePlan $tradePlan): RedirectResponse
    {
        $this->authorize('update', $tradePlan);

        $validated = $request->validate([
            'trade_result' => 'nullable|in:' . implode(',', array_keys(TradePlan::getTradeResults())),
        ]);

        $tradePlan->update($validated);

        return redirect()->back()
            ->with('success', 'Trade result updated successfully.');
    }
}
