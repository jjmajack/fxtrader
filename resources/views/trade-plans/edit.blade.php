@extends('layouts.app')

@section('title', 'Edit Trade Plan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i> Edit Trade Plan
            </h1>
            <div>
                <a href="{{ route('trade-plans.show', $tradePlan) }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-eye"></i> View
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Trade Plan Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('trade-plans.update', $tradePlan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $tradePlan->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trading_pair" class="form-label">Trading Pair *</label>
                                <select class="form-select @error('trading_pair') is-invalid @enderror" 
                                        id="trading_pair" name="trading_pair" required>
                                    <option value="">Select Trading Pair</option>
                                    @foreach(\App\Models\TradingPair::getGroupedForDropdown() as $category => $pairs)
                                        <optgroup label="{{ $category }}">
                                            @foreach($pairs as $symbol => $name)
                                                <option value="{{ $symbol }}" {{ old('trading_pair', $tradePlan->trading_pair) == $symbol ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                    <optgroup label="Custom">
                                        <option value="CUSTOM" {{ old('trading_pair', $tradePlan->trading_pair) == 'CUSTOM' ? 'selected' : '' }}>Custom Pair</option>
                                    </optgroup>
                                </select>
                                @error('trading_pair')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="custom-pair-input" style="display: none;" class="mt-2">
                                    <input type="text" class="form-control" id="custom_pair" name="custom_pair" 
                                           placeholder="Enter custom trading pair (e.g., BTC/ETH)"
                                           value="{{ old('custom_pair') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    @foreach(\App\Models\TradePlan::getStatuses() as $key => $label)
                                        <option value="{{ $key }}" {{ old('status', $tradePlan->status) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="strategy" class="form-label">Trading Strategy</label>
                                <select class="form-select @error('strategy') is-invalid @enderror" id="strategy" name="strategy">
                                    <option value="">Select Strategy</option>
                                    @foreach(\App\Models\TradePlan::getStrategies() as $key => $label)
                                        <option value="{{ $key }}" {{ old('strategy', $tradePlan->strategy) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('strategy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pattern_type" class="form-label">Pattern Type</label>
                                <select class="form-select @error('pattern_type') is-invalid @enderror" id="pattern_type" name="pattern_type">
                                    <option value="">Select Pattern</option>
                                    @foreach(\App\Models\TradePlan::getPatternTypes() as $key => $label)
                                        <option value="{{ $key }}" {{ old('pattern_type', $tradePlan->pattern_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pattern_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="trade_type" class="form-label">Trade Type</label>
                                <select class="form-select @error('trade_type') is-invalid @enderror" id="trade_type" name="trade_type">
                                    <option value="">Select Trade Type</option>
                                    @foreach(\App\Models\TradePlan::getTradeTypes() as $key => $label)
                                        <option value="{{ $key }}" {{ old('trade_type', $tradePlan->trade_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('trade_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_price" class="form-label">Entry Price</label>
                                <input type="number" step="0.00001" class="form-control @error('entry_price') is-invalid @enderror" 
                                       id="entry_price" name="entry_price" value="{{ old('entry_price', $tradePlan->entry_price) }}">
                                @error('entry_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exit_price" class="form-label">Exit Price</label>
                                <input type="number" step="0.00001" class="form-control @error('exit_price') is-invalid @enderror" 
                                       id="exit_price" name="exit_price" value="{{ old('exit_price', $tradePlan->exit_price) }}">
                                @error('exit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stop_loss" class="form-label">Stop Loss</label>
                                <input type="number" step="0.00001" class="form-control @error('stop_loss') is-invalid @enderror" 
                                       id="stop_loss" name="stop_loss" value="{{ old('stop_loss', $tradePlan->stop_loss) }}">
                                @error('stop_loss')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="take_profit" class="form-label">Take Profit</label>
                                <input type="number" step="0.00001" class="form-control @error('take_profit') is-invalid @enderror" 
                                       id="take_profit" name="take_profit" value="{{ old('take_profit', $tradePlan->take_profit) }}">
                                @error('take_profit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position_size" class="form-label">Position Size</label>
                                <input type="number" step="0.00001" class="form-control @error('position_size') is-invalid @enderror" 
                                       id="position_size" name="position_size" value="{{ old('position_size', $tradePlan->position_size) }}">
                                @error('position_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="risk_reward_ratio" class="form-label">Risk/Reward Ratio</label>
                                <input type="number" step="0.01" class="form-control @error('risk_reward_ratio') is-invalid @enderror" 
                                       id="risk_reward_ratio" name="risk_reward_ratio" value="{{ old('risk_reward_ratio', $tradePlan->risk_reward_ratio) }}">
                                @error('risk_reward_ratio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="risk_percentage" class="form-label">Risk Percentage (%)</label>
                                <input type="number" step="0.01" class="form-control @error('risk_percentage') is-invalid @enderror" 
                                       id="risk_percentage" name="risk_percentage" value="{{ old('risk_percentage', $tradePlan->risk_percentage) }}">
                                @error('risk_percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planned_entry_time" class="form-label">Planned Entry Time</label>
                                <input type="datetime-local" class="form-control @error('planned_entry_time') is-invalid @enderror" 
                                       id="planned_entry_time" name="planned_entry_time" 
                                       value="{{ old('planned_entry_time', $tradePlan->planned_entry_time?->format('Y-m-d\TH:i')) }}">
                                @error('planned_entry_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planned_exit_time" class="form-label">Planned Exit Time</label>
                                <input type="datetime-local" class="form-control @error('planned_exit_time') is-invalid @enderror" 
                                       id="planned_exit_time" name="planned_exit_time" 
                                       value="{{ old('planned_exit_time', $tradePlan->planned_exit_time?->format('Y-m-d\TH:i')) }}">
                                @error('planned_exit_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="actual_entry_time" class="form-label">Actual Entry Time</label>
                                <input type="datetime-local" class="form-control @error('actual_entry_time') is-invalid @enderror" 
                                       id="actual_entry_time" name="actual_entry_time" 
                                       value="{{ old('actual_entry_time', $tradePlan->actual_entry_time?->format('Y-m-d\TH:i')) }}">
                                @error('actual_entry_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="actual_exit_time" class="form-label">Actual Exit Time</label>
                                <input type="datetime-local" class="form-control @error('actual_exit_time') is-invalid @enderror" 
                                       id="actual_exit_time" name="actual_exit_time" 
                                       value="{{ old('actual_exit_time', $tradePlan->actual_exit_time?->format('Y-m-d\TH:i')) }}">
                                @error('actual_exit_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" 
                                  rows="4" placeholder="Add any additional notes or analysis...">{{ old('notes', $tradePlan->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="chart_image" class="form-label">
                            <i class="bi bi-image me-2"></i>Chart Screenshot
                        </label>
                        @if($tradePlan->hasChartImage())
                            <div class="mb-2">
                                <img src="{{ $tradePlan->getChartImageUrl() }}" alt="Current Chart" 
                                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                <div class="form-text">Current chart image</div>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('chart_image') is-invalid @enderror" 
                               id="chart_image" name="chart_image" accept="image/*">
                        <div class="form-text">
                            Upload a new chart screenshot to replace the current one (JPEG, PNG, JPG, GIF, WebP - Max 5MB)
                        </div>
                        @error('chart_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('trade-plans.show', $tradePlan) }}" class="btn btn-outline-secondary me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Trade Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Current Plan Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p class="mb-0">
                        <span class="badge status-{{ $tradePlan->status }} status-badge">
                            {{ ucfirst($tradePlan->status) }}
                        </span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Created</label>
                    <p class="mb-0">{{ $tradePlan->created_at->format('M d, Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated</label>
                    <p class="mb-0">{{ $tradePlan->updated_at->format('M d, Y H:i') }}</p>
                </div>

                @if($tradePlan->entry_price && $tradePlan->exit_price)
                <div class="mb-3">
                    <label class="form-label fw-bold">Current P&L</label>
                    <p class="mb-0">
                        @php
                            $pnlAmount = $tradePlan->getProfitLossAmount();
                            $pnlPercentage = $tradePlan->getProfitLossPercentage();
                        @endphp
                        @if($pnlAmount !== null)
                            <span class="{{ $pnlAmount >= 0 ? 'text-success' : 'text-danger' }}">
                                ${{ number_format($pnlAmount, 2) }} 
                                ({{ number_format($pnlPercentage, 2) }}%)
                            </span>
                        @else
                            <span class="text-muted">Cannot calculate</span>
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
