@extends('layouts.app')

@section('title', 'Trade Plans')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-2 fw-bold">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i> Trade Plans
                </h1>
                <p class="text-muted mb-0">Manage your trading strategies and monitor performance</p>
            </div>
            <a href="{{ route('trade-plans.create') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-plus-circle me-2"></i> New Trade Plan
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
@php
    $totalPlans = $tradePlans->total();
    $activePlans = \App\Models\TradePlan::where('user_id', auth()->id())->where('status', 'active')->count();
    $completedPlans = \App\Models\TradePlan::where('user_id', auth()->id())->where('status', 'completed')->count();
    $profitPlans = \App\Models\TradePlan::where('user_id', auth()->id())->where('status', 'completed')->where('trade_result', 'profit')->count();
@endphp

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-list-ul text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Plans</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalPlans }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-play-circle text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Active</h6>
                        <h3 class="mb-0 fw-bold">{{ $activePlans }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Completed</h6>
                        <h3 class="mb-0 fw-bold">{{ $completedPlans }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-trophy text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Profitable</h6>
                        <h3 class="mb-0 fw-bold">{{ $profitPlans }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex align-items-center">
            <i class="bi bi-funnel me-2 text-primary"></i>
            <h6 class="mb-0 fw-semibold">Filters</h6>
            <button class="btn btn-sm btn-link ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
    </div>
    <div class="collapse show" id="filterCollapse">
        <div class="card-body">
            <form method="GET" action="{{ route('trade-plans.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label fw-semibold">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by title...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        @foreach(\App\Models\TradePlan::getStatuses() as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="trade_result" class="form-label fw-semibold">Result</label>
                    <select class="form-select" id="trade_result" name="trade_result">
                        <option value="">All Results</option>
                        @foreach(\App\Models\TradePlan::getTradeResults() as $key => $label)
                            <option value="{{ $key }}" {{ request('trade_result') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="trading_pair" class="form-label fw-semibold">Trading Pair</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-currency-exchange"></i></span>
                        <input type="text" class="form-control border-start-0" id="trading_pair" name="trading_pair" 
                               value="{{ request('trading_pair') }}" placeholder="e.g., EUR/USD">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="sort_by" class="form-label fw-semibold">Sort By</label>
                    <select class="form-select" id="sort_by" name="sort_by">
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="trading_pair" {{ request('sort_by') == 'trading_pair' ? 'selected' : '' }}>Trading Pair</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Trade Plans Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-table me-2 text-primary"></i> Trade Plans List
            </h6>
            <span class="badge bg-light text-dark">{{ $tradePlans->count() }} {{ Str::plural('plan', $tradePlans->count()) }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        @if($tradePlans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Title</th>
                            <th>Pair</th>
                            <th>Strategy</th>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Entry</th>
                            <th>Stop Loss</th>
                            <th>Take Profit</th>
                            <th>Chart</th>
                            <th>Created</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tradePlans as $plan)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div>
                                    <strong class="text-dark">{{ $plan->title }}</strong>
                                    @if($plan->notes)
                                        <br><small class="text-muted">{{ Str::limit($plan->notes, 40) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $plan->trading_pair }}</span>
                            </td>
                            <td>
                                @if($plan->strategy)
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                        {{ \App\Models\TradePlan::getStrategies()[$plan->strategy] ?? ucfirst($plan->strategy) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge status-{{ $plan->status }} status-badge">
                                    <i class="bi bi-{{ $plan->status === 'active' ? 'play-circle' : ($plan->status === 'completed' ? 'check-circle' : 'clock') }} me-1"></i>
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
                                        $resultIcon = match($plan->trade_result) {
                                            'profit' => 'arrow-up-circle',
                                            'loss' => 'arrow-down-circle',
                                            'breakeven' => 'dash-circle',
                                            'pending' => 'clock',
                                            default => 'circle'
                                        };
                                    @endphp
                                    <span class="badge {{ $resultClass }}">
                                        <i class="bi bi-{{ $resultIcon }} me-1"></i>
                                        {{ \App\Models\TradePlan::getTradeResults()[$plan->trade_result] ?? ucfirst($plan->trade_result) }}
                                    </span>
                                @elseif($plan->status === 'completed')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->entry_price)
                                    <span class="text-dark fw-semibold">{{ $plan->formatPriceWithCurrency($plan->entry_price, $plan->getUserCurrencySymbol()) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->stop_loss)
                                    <span class="text-danger">{{ $plan->formatPriceWithCurrency($plan->stop_loss, $plan->getUserCurrencySymbol()) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->take_profit)
                                    <span class="text-success">{{ $plan->formatPriceWithCurrency($plan->take_profit, $plan->getUserCurrencySymbol()) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->hasChartImage())
                                    <img src="{{ $plan->getChartImageUrl() }}" alt="Chart" 
                                         class="chart-thumbnail shadow-sm" data-bs-toggle="modal" data-bs-target="#chartModal{{ $plan->id }}" style="cursor: pointer;">
                                @else
                                    <span class="text-muted">
                                        <i class="bi bi-image"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $plan->created_at->format('M d, Y') }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('trade-plans.show', $plan) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('trade-plans.edit', $plan) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <div id="status-updater-{{ $plan->id }}">
                                        <status-updater 
                                            :trade-plan-id="{{ $plan->id }}"
                                            current-status="{{ $plan->status }}"
                                        ></status-updater>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteTradePlan({{ $plan->id }})" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Hidden form for delete action -->
                                <form id="delete-form-{{ $plan->id }}" method="POST" action="{{ route('trade-plans.destroy', $plan) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $tradePlans->firstItem() ?? 0 }} to {{ $tradePlans->lastItem() ?? 0 }} of {{ $tradePlans->total() }} results
                    </div>
                    <div>
                        {{ $tradePlans->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-inbox text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
                <h4 class="text-muted mb-2">No trade plans found</h4>
                <p class="text-muted mb-4">Start by creating your first trade plan to track your trading strategies.</p>
                <a href="{{ route('trade-plans.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Create Trade Plan
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function deleteTradePlan(planId) {
    if (confirm('Are you sure you want to delete this trade plan? This action cannot be undone.')) {
        document.getElementById('delete-form-' + planId).submit();
    }
}

// Add animation to statistics cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 100);
    });
});
</script>
@endpush
@endsection
