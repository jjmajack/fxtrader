@extends('layouts.app')

@section('title', $tradePlan->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ $tradePlan->title }}</h1>
            <div>
                <a href="{{ route('trade-plans.edit', $tradePlan) }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Plans
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Basic Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trading Pair</label>
                            <p class="mb-0">
                                <span class="badge bg-light text-dark fs-6">{{ $tradePlan->trading_pair }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="mb-0">
                                <span class="badge status-{{ $tradePlan->status }} status-badge fs-6">
                                    {{ ucfirst($tradePlan->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trade Result</label>
                            <p class="mb-0">
                                @if($tradePlan->trade_result)
                                    @php
                                        $resultClass = match($tradePlan->trade_result) {
                                            'profit' => 'bg-success',
                                            'loss' => 'bg-danger',
                                            'breakeven' => 'bg-warning',
                                            'pending' => 'bg-secondary',
                                            default => 'bg-light text-dark'
                                        };
                                    @endphp
                                    <span class="badge {{ $resultClass }} fs-6">
                                        {{ \App\Models\TradePlan::getTradeResults()[$tradePlan->trade_result] ?? ucfirst($tradePlan->trade_result) }}
                                    </span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trading Strategy</label>
                            <p class="mb-0">
                                @if($tradePlan->strategy)
                                    <span class="badge bg-primary">{{ \App\Models\TradePlan::getStrategies()[$tradePlan->strategy] ?? ucfirst($tradePlan->strategy) }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pattern Type</label>
                            <p class="mb-0">
                                @if($tradePlan->pattern_type)
                                    <span class="badge bg-success">{{ \App\Models\TradePlan::getPatternTypes()[$tradePlan->pattern_type] ?? ucfirst($tradePlan->pattern_type) }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trade Type</label>
                            <p class="mb-0">
                                @if($tradePlan->trade_type)
                                    <span class="badge bg-info">{{ ucfirst($tradePlan->trade_type) }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Position Size</label>
                            <p class="mb-0">
                                @if($tradePlan->position_size)
                                    {{ $tradePlan->formatPrice($tradePlan->position_size) }}
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Price Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up"></i> Price Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Entry Price</label>
                            <p class="mb-0 fs-5">
                                @if($tradePlan->entry_price)
                                    ${{ $tradePlan->formatPrice($tradePlan->entry_price) }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Exit Price</label>
                            <p class="mb-0 fs-5">
                                @if($tradePlan->exit_price)
                                    ${{ $tradePlan->formatPrice($tradePlan->exit_price) }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Stop Loss</label>
                            <p class="mb-0 fs-5">
                                @if($tradePlan->stop_loss)
                                    ${{ $tradePlan->formatPrice($tradePlan->stop_loss) }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Take Profit</label>
                            <p class="mb-0 fs-5">
                                @if($tradePlan->take_profit)
                                    ${{ $tradePlan->formatPrice($tradePlan->take_profit) }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($tradePlan->entry_price && $tradePlan->exit_price)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">P&L Amount</label>
                            <p class="mb-0 fs-5">
                                @php
                                    $pnlAmount = $tradePlan->getProfitLossAmount();
                                @endphp
                                @if($pnlAmount !== null)
                                    <span class="{{ $pnlAmount >= 0 ? 'text-success' : 'text-danger' }}">
                                        ${{ $tradePlan->formatPrice($pnlAmount) }}
                                    </span>
                                @else
                                    <span class="text-muted">Cannot calculate</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">P&L Percentage</label>
                            <p class="mb-0 fs-5">
                                @php
                                    $pnlPercentage = $tradePlan->getProfitLossPercentage();
                                @endphp
                                @if($pnlPercentage !== null)
                                    <span class="{{ $pnlPercentage >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($pnlPercentage, 2) }}%
                                    </span>
                                @else
                                    <span class="text-muted">Cannot calculate</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Risk Management -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-shield-check"></i> Risk Management
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Risk/Reward Ratio</label>
                            <p class="mb-0">
                                @if($tradePlan->risk_reward_ratio)
                                    {{ number_format($tradePlan->risk_reward_ratio, 2) }}:1
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Risk Percentage</label>
                            <p class="mb-0">
                                @if($tradePlan->risk_percentage)
                                    {{ number_format($tradePlan->risk_percentage, 2) }}%
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timing Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-clock"></i> Timing Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Planned Entry Time</label>
                            <p class="mb-0">
                                @if($tradePlan->planned_entry_time)
                                    {{ $tradePlan->planned_entry_time->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Planned Exit Time</label>
                            <p class="mb-0">
                                @if($tradePlan->planned_exit_time)
                                    {{ $tradePlan->planned_exit_time->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Actual Entry Time</label>
                            <p class="mb-0">
                                @if($tradePlan->actual_entry_time)
                                    {{ $tradePlan->actual_entry_time->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Actual Exit Time</label>
                            <p class="mb-0">
                                @if($tradePlan->actual_exit_time)
                                    {{ $tradePlan->actual_exit_time->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($tradePlan->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text"></i> Notes
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $tradePlan->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Chart Screenshot -->
        @if($tradePlan->hasChartImage())
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up"></i> Technical Analysis Chart
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ $tradePlan->getChartImageUrl() }}" alt="Technical Analysis Chart" 
                         class="chart-preview">
                    <div class="mt-2">
                        <small class="text-muted">Click to view full size</small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('trade-plans.edit', $tradePlan) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Plan
                    </a>
                    
                    <!-- Status Update Form -->
                    <form method="POST" action="{{ route('trade-plans.update-status', $tradePlan) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-2">
                            <label for="status_update" class="form-label">Update Status</label>
                            <select class="form-select" id="status_update" name="status">
                                @foreach(\App\Models\TradePlan::getStatuses() as $key => $label)
                                    <option value="{{ $key }}" {{ $tradePlan->status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-repeat"></i> Update Status
                        </button>
                    </form>

                    <!-- Trade Result Update Form -->
                    <form method="POST" action="{{ route('trade-plans.update-result', $tradePlan) }}" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <div class="mb-2">
                            <label for="trade_result_update" class="form-label">Update Trade Result</label>
                            <select class="form-select" id="trade_result_update" name="trade_result">
                                <option value="">Select Result</option>
                                @foreach(\App\Models\TradePlan::getTradeResults() as $key => $label)
                                    <option value="{{ $key }}" {{ $tradePlan->trade_result == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="bi bi-check-circle"></i> Update Result
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Plan Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Plan Information
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Created</label>
                    <p class="mb-0">{{ $tradePlan->created_at->format('M d, Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated</label>
                    <p class="mb-0">{{ $tradePlan->updated_at->format('M d, Y H:i') }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Plan ID</label>
                    <p class="mb-0 text-muted">#{{ $tradePlan->id }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
