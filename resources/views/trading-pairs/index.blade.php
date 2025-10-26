@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-currency-exchange"></i> Trading Pairs Management</h2>
                <a href="{{ route('trading-pairs.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Pair
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Trading Pairs</h5>
                </div>
                <div class="card-body">
                    @if($tradingPairs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Decimals</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($tradingPairs as $pair)
                                    <tr>
                                        <td>
                                            <code>{{ $pair->symbol }}</code>
                                        </td>
                                        <td>{{ $pair->name }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ \App\Models\TradingPair::getCategories()[$pair->category] ?? ucfirst($pair->category) }}</span>
                                        </td>
                                        <td>
                                            @if($pair->subcategory)
                                                <span class="badge bg-secondary">{{ \App\Models\TradingPair::getSubcategories()[$pair->subcategory] ?? ucfirst($pair->subcategory) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $pair->decimal_precision }} decimals</span>
                                        </td>
                                        <td>
                                            @if($pair->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $pair->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('trading-pairs.show', $pair) }}" class="btn btn-sm btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('trading-pairs.edit', $pair) }}" class="btn btn-sm btn-outline-secondary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('trading-pairs.toggle-status', $pair) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $pair->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} btn-sm">
                                                        <i class="bi bi-{{ $pair->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('trading-pairs.destroy', $pair) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this trading pair?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $tradingPairs->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-currency-exchange display-1 text-muted"></i>
                            <h4 class="mt-3">No Trading Pairs Found</h4>
                            <p class="text-muted">Start by adding your first trading pair.</p>
                            <a href="{{ route('trading-pairs.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add First Trading Pair
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
