@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-plus-circle"></i> Add New Trading Pair</h2>
                <a href="{{ route('trading-pairs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Trading Pairs
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Trading Pair Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('trading-pairs.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="symbol" class="form-label">Symbol *</label>
                                            <input type="text" class="form-control @error('symbol') is-invalid @enderror" 
                                                   id="symbol" name="symbol" value="{{ old('symbol') }}" 
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
                                                   id="name" name="name" value="{{ old('name') }}" 
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
                                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
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
                                                    <option value="{{ $key }}" {{ old('subcategory') == $key ? 'selected' : '' }}>
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
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
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
                                                <option value="0" {{ old('decimal_precision', 4) == 0 ? 'selected' : '' }}>0 decimals (e.g., 1234)</option>
                                                <option value="1" {{ old('decimal_precision', 4) == 1 ? 'selected' : '' }}>1 decimal (e.g., 1234.5)</option>
                                                <option value="2" {{ old('decimal_precision', 4) == 2 ? 'selected' : '' }}>2 decimals (e.g., 1234.50) - Gold, Silver</option>
                                                <option value="3" {{ old('decimal_precision', 4) == 3 ? 'selected' : '' }}>3 decimals (e.g., 1234.500)</option>
                                                <option value="4" {{ old('decimal_precision', 4) == 4 ? 'selected' : '' }}>4 decimals (e.g., 1234.5000) - Forex</option>
                                                <option value="5" {{ old('decimal_precision', 4) == 5 ? 'selected' : '' }}>5 decimals (e.g., 1234.50000)</option>
                                                <option value="6" {{ old('decimal_precision', 4) == 6 ? 'selected' : '' }}>6 decimals (e.g., 1234.500000)</option>
                                                <option value="7" {{ old('decimal_precision', 4) == 7 ? 'selected' : '' }}>7 decimals (e.g., 1234.5000000)</option>
                                                <option value="8" {{ old('decimal_precision', 4) == 8 ? 'selected' : '' }}>8 decimals (e.g., 1234.50000000)</option>
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
                                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active (Available for selection)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Create Trading Pair
                                    </button>
                                    <a href="{{ route('trading-pairs.index') }}" class="btn btn-secondary">
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
                                <i class="bi bi-info-circle"></i> Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Symbol:</strong> Use standard format like EUR/USD, US30, BTC/USD
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Name:</strong> Use descriptive names for easy identification
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Category:</strong> Group similar trading pairs together
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Sort Order:</strong> Lower numbers appear first in dropdowns
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <strong>Active:</strong> Only active pairs appear in trade plan forms
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
