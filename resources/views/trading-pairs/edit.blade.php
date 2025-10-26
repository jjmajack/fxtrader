@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-pencil"></i> Edit Trading Pair</h2>
                <div class="btn-group">
                    <a href="{{ route('trading-pairs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Trading Pairs
                    </a>
                    <a href="{{ route('trading-pairs.show', $tradingPair) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> View
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Trading Pair: {{ $tradingPair->symbol }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('trading-pairs.update', $tradingPair) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="symbol" class="form-label">Symbol *</label>
                                            <input type="text" class="form-control @error('symbol') is-invalid @enderror" 
                                                   id="symbol" name="symbol" value="{{ old('symbol', $tradingPair->symbol) }}" 
                                                   placeholder="e.g., EUR/USD, US30, BTC/USD" required>
                                            @error('symbol')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Display Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $tradingPair->name) }}" 
                                                   placeholder="e.g., Euro/US Dollar, Dow Jones, Bitcoin/US Dollar" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category *</label>
                                            <select class="form-select @error('category') is-invalid @enderror" 
                                                    id="category" name="category" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $key => $label)
                                                    <option value="{{ $key }}" {{ old('category', $tradingPair->category) == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subcategory" class="form-label">Subcategory</label>
                                            <select class="form-select @error('subcategory') is-invalid @enderror" 
                                                    id="subcategory" name="subcategory">
                                                <option value="">Select Subcategory (Optional)</option>
                                                @foreach($subcategories as $key => $label)
                                                    <option value="{{ $key }}" {{ old('subcategory', $tradingPair->subcategory) == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $tradingPair->sort_order) }}" 
                                                   min="0" placeholder="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="decimal_precision" class="form-label">Decimal Precision *</label>
                                            <select class="form-select @error('decimal_precision') is-invalid @enderror" 
                                                    id="decimal_precision" name="decimal_precision" required>
                                                <option value="">Select Decimal Places</option>
                                                <option value="0" {{ old('decimal_precision', $tradingPair->decimal_precision) == 0 ? 'selected' : '' }}>0 decimals (e.g., 1234)</option>
                                                <option value="1" {{ old('decimal_precision', $tradingPair->decimal_precision) == 1 ? 'selected' : '' }}>1 decimal (e.g., 1234.5)</option>
                                                <option value="2" {{ old('decimal_precision', $tradingPair->decimal_precision) == 2 ? 'selected' : '' }}>2 decimals (e.g., 1234.50) - Gold, Silver</option>
                                                <option value="3" {{ old('decimal_precision', $tradingPair->decimal_precision) == 3 ? 'selected' : '' }}>3 decimals (e.g., 1234.500)</option>
                                                <option value="4" {{ old('decimal_precision', $tradingPair->decimal_precision) == 4 ? 'selected' : '' }}>4 decimals (e.g., 1234.5000) - Forex</option>
                                                <option value="5" {{ old('decimal_precision', $tradingPair->decimal_precision) == 5 ? 'selected' : '' }}>5 decimals (e.g., 1234.50000)</option>
                                                <option value="6" {{ old('decimal_precision', $tradingPair->decimal_precision) == 6 ? 'selected' : '' }}>6 decimals (e.g., 1234.500000)</option>
                                                <option value="7" {{ old('decimal_precision', $tradingPair->decimal_precision) == 7 ? 'selected' : '' }}>7 decimals (e.g., 1234.5000000)</option>
                                                <option value="8" {{ old('decimal_precision', $tradingPair->decimal_precision) == 8 ? 'selected' : '' }}>8 decimals (e.g., 1234.50000000)</option>
                                            </select>
                                            @error('decimal_precision')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                       value="1" {{ old('is_active', $tradingPair->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active (Available for selection)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update Trading Pair
                                    </button>
                                    <a href="{{ route('trading-pairs.show', $tradingPair) }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle"></i> Current Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Symbol:</strong> <code>{{ $tradingPair->symbol }}</code>
                                </li>
                                <li class="mb-2">
                                    <strong>Name:</strong> {{ $tradingPair->name }}
                                </li>
                                <li class="mb-2">
                                    <strong>Category:</strong> 
                                    <span class="badge bg-info">
                                        {{ \App\Models\TradingPair::getCategories()[$tradingPair->category] ?? ucfirst($tradingPair->category) }}
                                    </span>
                                </li>
                                <li class="mb-2">
                                    <strong>Subcategory:</strong> 
                                    @if($tradingPair->subcategory)
                                        <span class="badge bg-secondary">
                                            {{ \App\Models\TradingPair::getSubcategories()[$tradingPair->subcategory] ?? ucfirst($tradingPair->subcategory) }}
                                        </span>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <strong>Status:</strong> 
                                    @if($tradingPair->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </li>
                                <li class="mb-0">
                                    <strong>Sort Order:</strong> {{ $tradingPair->sort_order }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-lightbulb"></i> Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Symbol:</strong> Must be unique across all trading pairs
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Name:</strong> Used in dropdown menus and displays
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Category:</strong> Groups pairs in dropdown menus
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Sort Order:</strong> Lower numbers appear first
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Active:</strong> Only active pairs appear in forms
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
