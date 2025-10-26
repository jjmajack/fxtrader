@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-currency-exchange"></i> Trading Pair Details</h2>
                <div class="btn-group">
                    <a href="{{ route('trading-pairs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Trading Pairs
                    </a>
                    <a href="{{ route('trading-pairs.edit', $tradingPair) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Trading Pair Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Symbol</label>
                                        <p class="mb-0">
                                            <code class="fs-5">{{ $tradingPair->symbol }}</code>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Display Name</label>
                                        <p class="mb-0 fs-5">{{ $tradingPair->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Category</label>
                                        <p class="mb-0">
                                            <span class="badge bg-info fs-6">
                                                {{ \App\Models\TradingPair::getCategories()[$tradingPair->category] ?? ucfirst($tradingPair->category) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Subcategory</label>
                                        <p class="mb-0">
                                            @if($tradingPair->subcategory)
                                                <span class="badge bg-secondary fs-6">
                                                    {{ \App\Models\TradingPair::getSubcategories()[$tradingPair->subcategory] ?? ucfirst($tradingPair->subcategory) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="mb-0">
                                            @if($tradingPair->is_active)
                                                <span class="badge bg-success fs-6">
                                                    <i class="bi bi-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger fs-6">
                                                    <i class="bi bi-x-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sort Order</label>
                                        <p class="mb-0 fs-5">{{ $tradingPair->sort_order }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created</label>
                                        <p class="mb-0">{{ $tradingPair->created_at->format('M d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <p class="mb-0">{{ $tradingPair->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-gear"></i> Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('trading-pairs.edit', $tradingPair) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Edit Trading Pair
                                </a>
                                
                                <form action="{{ route('trading-pairs.toggle-status', $tradingPair) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $tradingPair->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                        <i class="bi bi-{{ $tradingPair->is_active ? 'pause' : 'play' }}"></i>
                                        {{ $tradingPair->is_active ? 'Deactivate' : 'Activate' }} Pair
                                    </button>
                                </form>

                                <form action="{{ route('trading-pairs.destroy', $tradingPair) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this trading pair? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Delete Trading Pair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle"></i> Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong>Symbol:</strong> Used as the unique identifier
                                </li>
                                <li class="mb-2">
                                    <strong>Name:</strong> Displayed in dropdown menus
                                </li>
                                <li class="mb-2">
                                    <strong>Category:</strong> Groups similar trading pairs
                                </li>
                                <li class="mb-2">
                                    <strong>Status:</strong> Only active pairs appear in forms
                                </li>
                                <li class="mb-0">
                                    <strong>Sort Order:</strong> Controls display sequence
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



