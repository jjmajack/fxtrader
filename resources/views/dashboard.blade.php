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

<div id="app">
    <dashboard-stats></dashboard-stats>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-list-ul text-primary" style="font-size: 2rem;"></i>
                <h5 class="card-title mt-2">{{ $totalPlans }}</h5>
                <p class="card-text text-muted">Total Plans</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-play-circle text-success" style="font-size: 2rem;"></i>
                <h5 class="card-title mt-2">{{ $activePlans }}</h5>
                <p class="card-text text-muted">Active Plans</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-check-circle text-info" style="font-size: 2rem;"></i>
                <h5 class="card-title mt-2">{{ $completedPlans }}</h5>
                <p class="card-text text-muted">Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-file-earmark text-secondary" style="font-size: 2rem;"></i>
                <h5 class="card-title mt-2">{{ $draftPlans }}</h5>
                <p class="card-text text-muted">Draft Plans</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Trade Plans -->
    <div class="col-md-8">
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
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPlans as $plan)
                                <tr>
                                    <td>{{ $plan->title }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $plan->trading_pair }}</span>
                                    </td>
                                    <td>
                                        <span class="badge status-{{ $plan->status }} status-badge">
                                            {{ ucfirst($plan->status) }}
                                        </span>
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
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No trade plans yet</p>
                        <a href="{{ route('trade-plans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Create Your First Plan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="col-md-4">
        <!-- Status Distribution -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-pie-chart"></i> Plans by Status
                </h6>
            </div>
            <div class="card-body">
                @if(count($plansByStatus) > 0)
                    @foreach($plansByStatus as $status => $count)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge status-{{ $status }} status-badge">
                            {{ ucfirst($status) }}
                        </span>
                        <span class="fw-bold">{{ $count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>

        <!-- Top Trading Pairs -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-graph-up"></i> Top Trading Pairs
                </h6>
            </div>
            <div class="card-body">
                @if(count($plansByPair) > 0)
                    @foreach($plansByPair as $pair => $count)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-light text-dark">{{ $pair }}</span>
                        <span class="fw-bold">{{ $count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('trade-plans.create') }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-plus-circle"></i> New Trade Plan
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('trade-plans.index') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-list-ul"></i> View All Plans
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('trade-plans.index', ['status' => 'active']) }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="bi bi-play-circle"></i> Active Plans
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('trade-plans.index', ['status' => 'completed']) }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="bi bi-check-circle"></i> Completed Plans
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

