<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'FX Trader')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--light-bg);
            color: #1e293b;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: var(--shadow-md);
            border: none;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
            background: white;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid var(--border-color);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
            font-weight: 600;
            color: #334155;
        }

        .btn {
            border-radius: var(--radius);
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-1px);
        }

        .table {
            border-radius: var(--radius);
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: none;
            font-weight: 600;
            color: #475569;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            border-radius: var(--radius);
            font-weight: 500;
            padding: 0.375rem 0.75rem;
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-draft { 
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
        }
        .status-active { 
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
        }
        .status-completed { 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }
        .status-cancelled { 
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            color: white;
        }
        .status-expired { 
            background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
            color: white;
        }

        .form-control, .form-select {
            border-radius: var(--radius);
            border: 2px solid var(--border-color);
            transition: all 0.2s ease;
            padding: 0.75rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .alert {
            border-radius: var(--radius);
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .pagination {
            border-radius: var(--radius);
        }

        .page-link {
            border: none;
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: var(--radius);
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
        }

        .spinner-border {
            color: var(--primary-color);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .bg-light {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Chart image styles */
        .chart-thumbnail {
            width: 40px;
            height: 30px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            transition: transform 0.2s ease;
        }

        .chart-thumbnail:hover {
            transform: scale(1.1);
            z-index: 10;
            position: relative;
        }

        .chart-preview {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="bi bi-graph-up"></i> FX Trader
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('trade-plans.index') }}">
                                <i class="bi bi-list-ul"></i> Trade Plans
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('trading-pairs.index') }}">
                                <i class="bi bi-currency-exchange"></i> Trading Pairs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('trade-plans.create') }}">
                                <i class="bi bi-plus-circle"></i> New Plan
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vue.js will be loaded by Vite -->
</body>
</html>
