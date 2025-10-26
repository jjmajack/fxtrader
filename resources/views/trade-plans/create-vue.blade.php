@extends('layouts.app')

@section('title', 'Create Trade Plan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle"></i> Create Trade Plan
            </h1>
            <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Plans
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up"></i> Trade Plan Details
                </h5>
            </div>
            <div class="card-body">
                <div id="app">
                    <trade-plan-form 
                        :trading-pairs="{{ json_encode(\App\Models\TradingPair::getGroupedForDropdown()) }}"
                        :strategies="{{ json_encode(\App\Models\TradePlan::getStrategies()) }}"
                        :pattern-types="{{ json_encode(\App\Models\TradePlan::getPatternTypes()) }}"
                        :trade-types="{{ json_encode(\App\Models\TradePlan::getTradeTypes()) }}"
                    ></trade-plan-form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Quick Tips
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="bi bi-lightbulb"></i> Trading Tips
                    </h6>
                    <ul class="mb-0">
                        <li>Always set stop loss and take profit levels</li>
                        <li>Risk only 1-2% of your account per trade</li>
                        <li>Use proper position sizing</li>
                        <li>Document your trading strategy</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle"></i> Risk Management
                    </h6>
                    <p class="mb-0">
                        Never risk more than you can afford to lose. 
                        Use proper risk management techniques.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



