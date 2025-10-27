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

        // Calculate profit/loss statistics
        $completedTrades = $user->tradePlans()
            ->where('status', TradePlan::STATUS_COMPLETED)
            ->whereNotNull('trade_result')
            ->get();

        $profitTrades = $completedTrades->where('trade_result', TradePlan::TRADE_RESULT_PROFIT);
        $lossTrades = $completedTrades->where('trade_result', TradePlan::TRADE_RESULT_LOSS);
        $breakevenTrades = $completedTrades->where('trade_result', TradePlan::TRADE_RESULT_BREAKEVEN);

        $totalProfitTrades = $profitTrades->count();
        $totalLossTrades = $lossTrades->count();
        $totalBreakevenTrades = $breakevenTrades->count();
        $totalCompletedTrades = $completedTrades->count();

        // Calculate win rate
        $winRate = $totalCompletedTrades > 0 ? round(($totalProfitTrades / $totalCompletedTrades) * 100, 1) : 0;

        // Calculate total profit/loss amounts
        $totalProfitAmount = $profitTrades->sum(function($trade) {
            return $trade->getProfitLossAmount() ?? 0;
        });
        $totalLossAmount = $lossTrades->sum(function($trade) {
            return $trade->getProfitLossAmount() ?? 0;
        });
        $netProfitLoss = $totalProfitAmount + $totalLossAmount; // Loss amounts are negative

        // Get profit/loss by trading pair
        $profitLossByPair = $user->tradePlans()
            ->where('status', TradePlan::STATUS_COMPLETED)
            ->whereNotNull('trade_result')
            ->selectRaw('trading_pair, trade_result, count(*) as count')
            ->groupBy('trading_pair', 'trade_result')
            ->get()
            ->groupBy('trading_pair')
            ->map(function($trades) {
                $profitCount = $trades->where('trade_result', TradePlan::TRADE_RESULT_PROFIT)->sum('count');
                $lossCount = $trades->where('trade_result', TradePlan::TRADE_RESULT_LOSS)->sum('count');
                $breakevenCount = $trades->where('trade_result', TradePlan::TRADE_RESULT_BREAKEVEN)->sum('count');
                $total = $profitCount + $lossCount + $breakevenCount;
                
                return [
                    'profit' => $profitCount,
                    'loss' => $lossCount,
                    'breakeven' => $breakevenCount,
                    'total' => $total,
                    'win_rate' => $total > 0 ? round(($profitCount / $total) * 100, 1) : 0
                ];
            });

        return view('dashboard-simple', compact(
            'totalPlans',
            'activePlans', 
            'completedPlans',
            'draftPlans',
            'recentPlans',
            'plansByStatus',
            'plansByPair',
            'totalProfitTrades',
            'totalLossTrades',
            'totalBreakevenTrades',
            'totalCompletedTrades',
            'winRate',
            'totalProfitAmount',
            'totalLossAmount',
            'netProfitLoss',
            'profitLossByPair'
        ));
    }
}
