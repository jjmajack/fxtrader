<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TradePlan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with trade plan statistics.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get trade plan statistics
        $totalPlans = $user->tradePlans()->count();
        $activePlans = $user->tradePlans()->where('status', TradePlan::STATUS_ACTIVE)->count();
        $completedPlans = $user->tradePlans()->where('status', TradePlan::STATUS_COMPLETED)->count();
        $draftPlans = $user->tradePlans()->where('status', TradePlan::STATUS_DRAFT)->count();
        
        // Get recent trade plans
        $recentPlans = $user->tradePlans()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get trade plans by status
        $plansByStatus = $user->tradePlans()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Get trade plans by trading pair
        $plansByPair = $user->tradePlans()
            ->selectRaw('trading_pair, count(*) as count')
            ->groupBy('trading_pair')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'trading_pair')
            ->toArray();

        return view('dashboard-simple', compact(
            'totalPlans',
            'activePlans', 
            'completedPlans',
            'draftPlans',
            'recentPlans',
            'plansByStatus',
            'plansByPair'
        ));
    }
}
