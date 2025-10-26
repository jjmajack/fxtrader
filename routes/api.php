<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\TradingPair;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Trading Pairs API
Route::middleware('auth')->group(function () {
    Route::get('/trading-pairs', function () {
        return response()->json([
            'data' => TradingPair::orderBy('category')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
        ]);
    });
    
    Route::get('/trading-pairs/{tradingPair}', function (TradingPair $tradingPair) {
        return response()->json($tradingPair);
    });
    
    // Dashboard API
    Route::get('/dashboard-data', function () {
        $user = auth()->user();
        
        $stats = [
            'totalPlans' => $user->tradePlans()->count(),
            'activePlans' => $user->tradePlans()->where('status', 'active')->count(),
            'completedPlans' => $user->tradePlans()->where('status', 'completed')->count(),
            'draftPlans' => $user->tradePlans()->where('status', 'draft')->count(),
        ];
        
        $recentPlans = $user->tradePlans()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $plansByStatus = $user->tradePlans()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $plansByPair = $user->tradePlans()
            ->selectRaw('trading_pair, count(*) as count')
            ->groupBy('trading_pair')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'trading_pair')
            ->toArray();
        
        return response()->json([
            'stats' => $stats,
            'recentPlans' => $recentPlans,
            'plansByStatus' => $plansByStatus,
            'plansByPair' => $plansByPair
        ]);
    });
});

