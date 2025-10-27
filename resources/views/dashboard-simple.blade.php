@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h1>
    </div>
</div>

<!-- Modern Statistics Cards -->
<div class="row mb-5">
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-list-ul text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $totalPlans }}</h2>
                <p class="text-muted mb-0 fw-medium">Total Plans</p>
                <small class="text-success">
                    <i class="bi bi-arrow-up"></i> All time
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.1s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-play-circle text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $activePlans }}</h2>
                <p class="text-muted mb-0 fw-medium">Active Plans</p>
                <small class="text-success">
                    <i class="bi bi-arrow-up"></i> Running
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.2s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-check-circle text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $completedPlans }}</h2>
                <p class="text-muted mb-0 fw-medium">Completed</p>
                <small class="text-info">
                    <i class="bi bi-trophy"></i> Finished
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.3s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-file-earmark text-secondary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $draftPlans }}</h2>
                <p class="text-muted mb-0 fw-medium">Draft Plans</p>
                <small class="text-warning">
                    <i class="bi bi-pencil"></i> In progress
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Profit/Loss Summary Cards -->
@if($totalCompletedTrades > 0)
<div class="row mb-5">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="bi bi-graph-up-arrow text-success me-2"></i> Trading Performance
        </h4>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.4s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-trophy text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-success mb-1">{{ $totalProfitTrades }}</h2>
                <p class="text-muted mb-0 fw-medium">Profitable Trades</p>
                <small class="text-success">
                    <i class="bi bi-arrow-up"></i> {{ $winRate }}% Win Rate
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-graph-down text-danger" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-danger mb-1">{{ $totalLossTrades }}</h2>
                <p class="text-muted mb-0 fw-medium">Loss Trades</p>
                <small class="text-danger">
                    <i class="bi bi-arrow-down"></i> {{ $totalCompletedTrades - $totalProfitTrades - $totalBreakevenTrades }}% Loss Rate
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.6s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-dash-circle text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-warning mb-1">{{ $totalBreakevenTrades }}</h2>
                <p class="text-muted mb-0 fw-medium">Breakeven Trades</p>
                <small class="text-warning">
                    <i class="bi bi-dash"></i> {{ $totalBreakevenTrades > 0 ? round(($totalBreakevenTrades / $totalCompletedTrades) * 100, 1) : 0 }}% Breakeven Rate
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 fade-in-up" style="animation-delay: 0.7s;">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="bg-{{ $netProfitLoss >= 0 ? 'success' : 'danger' }} bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-currency-dollar text-{{ $netProfitLoss >= 0 ? 'success' : 'danger' }}" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-{{ $netProfitLoss >= 0 ? 'success' : 'danger' }} mb-1">
                    {{ Auth::user()->getCurrencySymbol() }}{{ number_format(abs($netProfitLoss), 2) }}
                </h2>
                <p class="text-muted mb-0 fw-medium">Net P&L</p>
                <small class="text-{{ $netProfitLoss >= 0 ? 'success' : 'danger' }}">
                    <i class="bi bi-arrow-{{ $netProfitLoss >= 0 ? 'up' : 'down' }}"></i> {{ $netProfitLoss >= 0 ? 'Profit' : 'Loss' }}
                </small>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Profit/Loss Matrix and Recent Trade Plans -->
<div class="row">
    @if($profitLossByPair->count() > 0)
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-table"></i> Profit/Loss Matrix by Trading Pair
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover profit-loss-matrix">
                        <thead>
                            <tr>
                                <th>Trading Pair</th>
                                <th class="text-center">Profit</th>
                                <th class="text-center">Loss</th>
                                <th class="text-center">Breakeven</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Win Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profitLossByPair as $pair => $data)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $pair }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $data['profit'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $data['loss'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">{{ $data['breakeven'] }}</span>
                                </td>
                                <td class="text-center fw-bold">{{ $data['total'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $data['win_rate'] >= 50 ? 'success' : ($data['win_rate'] >= 30 ? 'warning' : 'danger') }}">
                                        {{ $data['win_rate'] }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-md-{{ $profitLossByPair->count() > 0 ? '6' : '8' }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Recent Trade Plans
                </h5>
                <a href="{{ route('trade-plans.index') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($recentPlans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Pair</th>
                                    <th>Status</th>
                                    <th>Result</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPlans as $plan)
                                <tr>
                                    <td>{{ $plan->title }}</td>
                                    <td>{{ $plan->trading_pair }}</td>
                                    <td>
                                        <span class="badge status-{{ $plan->status }} status-badge">
                                            {{ ucfirst($plan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($plan->status === 'completed' && $plan->trade_result)
                                            @php
                                                $resultClass = match($plan->trade_result) {
                                                    'profit' => 'bg-success',
                                                    'loss' => 'bg-danger',
                                                    'breakeven' => 'bg-warning',
                                                    'pending' => 'bg-secondary',
                                                    default => 'bg-light text-dark'
                                                };
                                            @endphp
                                            <span class="badge {{ $resultClass }}">
                                                {{ ucfirst($plan->trade_result) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $plan->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('trade-plans.show', $plan) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-inbox fs-1"></i>
                        <p>No trade plans yet</p>
                        <a href="{{ route('trade-plans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create Your First Plan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('trade-plans.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> New Trade Plan
                    </a>
                    <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i> View All Plans
                    </a>
                    <a href="{{ route('trading-pairs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-currency-exchange"></i> Trading Pairs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
