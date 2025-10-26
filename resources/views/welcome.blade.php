<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FX Trader - Professional Trading Plan Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <i class="bi bi-graph-up"></i> FX Trader
                    </a>
                    
                    <div class="navbar-nav ms-auto">
                        @auth
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">
                        Professional Trading Plan Management
                    </h1>
                    <p class="lead text-white mb-4">
                        Plan, track, and monitor your trading activities with our comprehensive trading plan management system. 
                        Create detailed trade plans, set entry and exit points, manage risk, and track your performance.
                    </p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-speedometer2"></i> Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-person-plus"></i> Get Started
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Sign In
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="bi bi-graph-up text-white" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold">Key Features</h2>
                    <p class="lead text-muted">Everything you need to manage your trading plans</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-list-ul text-primary" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Trade Plan Management</h5>
                            <p class="card-text">Create, edit, and organize your trading plans with detailed entry and exit strategies.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-shield-check text-success" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Risk Management</h5>
                            <p class="card-text">Set stop losses, take profits, and calculate risk-reward ratios for every trade.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-graph-up text-info" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Performance Tracking</h5>
                            <p class="card-text">Monitor your trading performance with detailed analytics and profit/loss calculations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Start Trading?</h2>
            <p class="lead mb-4">Join thousands of traders who use our platform to manage their trading plans.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-speedometer2"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
                    <i class="bi bi-person-plus"></i> Create Account
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} FX Trader. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>