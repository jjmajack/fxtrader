@extends('layouts.app')

@section('title', 'Trade Plans')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 mb-2 fw-bold">
                    <i class="bi bi-graph-up text-primary me-2"></i> Trade Plans
                </h1>
                <p class="text-muted mb-0">Manage your trading strategies and monitor performance</p>
            </div>
            <a href="{{ route('trade-plans.create') }}" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-plus-circle me-2"></i> New Trade Plan
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('trade-plans.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by title...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
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
                <label for="trade_result" class="form-label">Result</label>
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
                <label for="trading_pair" class="form-label">Trading Pair</label>
                <input type="text" class="form-control" id="trading_pair" name="trading_pair" 
                       value="{{ request('trading_pair') }}" placeholder="e.g., EUR/USD">
            </div>
            <div class="col-md-3">
                <label for="sort_by" class="form-label">Sort By</label>
                <select class="form-select" id="sort_by" name="sort_by">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="trading_pair" {{ request('sort_by') == 'trading_pair' ? 'selected' : '' }}>Trading Pair</option>
                    <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Trade Plans Table -->
<div class="card">
    <div class="card-body">
        @if($tradePlans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Pair</th>
                            <th>Strategy</th>
                            <th>Pattern</th>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Entry Price</th>
                            <th>Stop Loss</th>
                            <th>Take Profit</th>
                            <th>Chart</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tradePlans as $plan)
                        <tr>
                            <td>
                                <strong>{{ $plan->title }}</strong>
                                @if($plan->notes)
                                    <br><small class="text-muted">{{ Str::limit($plan->notes, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $plan->trading_pair }}</span>
                            </td>
                            <td>
                                @if($plan->strategy)
                                    <span class="badge bg-primary">{{ \App\Models\TradePlan::getStrategies()[$plan->strategy] ?? ucfirst($plan->strategy) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->pattern_type)
                                    <span class="badge bg-success">{{ \App\Models\TradePlan::getPatternTypes()[$plan->pattern_type] ?? ucfirst($plan->pattern_type) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
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
                                        {{ \App\Models\TradePlan::getTradeResults()[$plan->trade_result] ?? ucfirst($plan->trade_result) }}
                                    </span>
                                @elseif($plan->status === 'completed')
                                    <span class="badge bg-secondary">Pending</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->entry_price)
                                    {{ $plan->formatPriceWithCurrency($plan->entry_price, $plan->getUserCurrencySymbol()) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->stop_loss)
                                    {{ $plan->formatPriceWithCurrency($plan->stop_loss, $plan->getUserCurrencySymbol()) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->take_profit)
                                    {{ $plan->formatPriceWithCurrency($plan->take_profit, $plan->getUserCurrencySymbol()) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->hasChartImage())
                                    <img src="{{ $plan->getChartImageUrl() }}" alt="Chart" 
                                         class="chart-thumbnail">
                                @else
                                    <span class="text-muted">
                                        <i class="bi bi-image"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $plan->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('trade-plans.show', $plan) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('trade-plans.edit', $plan) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <div id="status-updater-{{ $plan->id }}">
                                        <status-updater 
                                            :trade-plan-id="{{ $plan->id }}"
                                            current-status="{{ $plan->status }}"
                                        ></status-updater>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteTradePlan({{ $plan->id }})">
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
            <div class="d-flex justify-content-center mt-4">
                {{ $tradePlans->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No trade plans found</h4>
                <p class="text-muted">Start by creating your first trade plan.</p>
                <a href="{{ route('trade-plans.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Create Trade Plan
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function deleteTradePlan(planId) {
    if (confirm('Are you sure you want to delete this trade plan?')) {
        document.getElementById('delete-form-' + planId).submit();
    }
}
</script>
@endsection
