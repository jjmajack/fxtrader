<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TradePlanController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('welcome');
});

// Migration route - bypasses session to run before tables exist
Route::get('/migrate', function () {
    $token = request()->query('token');
    $secretToken = env('MIGRATION_TOKEN', env('APP_KEY', 'your-secret-token'));
    if ($token !== $secretToken) {
        return response('Unauthorized - Invalid token', 401);
    }
    
    // Use array driver to avoid database dependency
    putenv('SESSION_DRIVER=array');
    config(['session.driver' => 'array']);
    
    try {
        // Clear any cached config
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        
        // Run migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return '<pre>Migrations completed successfully!<br><br>' . htmlspecialchars($output) . '</pre>';
    } catch (\Exception $e) {
        return '<pre>Error: ' . htmlspecialchars($e->getMessage()) . '<br><br>Stack trace:<br>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    }
})->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class]);

// Clear cache route
Route::get('/clear-cache', function () {
    $token = request()->query('token');
    $secretToken = env('MIGRATION_TOKEN', env('APP_KEY', 'your-secret-token'));
    if ($token !== $secretToken) {
        return response('Unauthorized - Invalid token', 401);
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        return '<pre>Cache cleared successfully!</pre>';
    } catch (\Exception $e) {
        return '<pre>Error: ' . htmlspecialchars($e->getMessage()) . '</pre>';
    }
});

// Check environment variables (for debugging)
Route::get('/check-env', function () {
    $token = request()->query('token');
    $secretToken = env('MIGRATION_TOKEN', env('APP_KEY', 'your-secret-token'));
    if ($token !== $secretToken) {
        return response('Unauthorized - Invalid token', 401);
    }
    
    $envPath = base_path('.env');
    $envExists = file_exists($envPath);
    $configCached = app()->configurationIsCached();
    
    // Check both env() and config() values
    $dbHostEnv = env('DB_HOST', 'NOT SET');
    $dbDatabaseEnv = env('DB_DATABASE', 'NOT SET');
    $dbUsernameEnv = env('DB_USERNAME', 'NOT SET');
    $dbPasswordEnv = env('DB_PASSWORD') ? '***SET***' : 'NOT SET';
    $dbConnectionEnv = env('DB_CONNECTION', 'NOT SET');
    
    $dbHostConfig = config('database.connections.mysql.host', 'NOT SET');
    $dbDatabaseConfig = config('database.connections.mysql.database', 'NOT SET');
    $dbUsernameConfig = config('database.connections.mysql.username', 'NOT SET');
    $dbPasswordConfig = config('database.connections.mysql.password') ? '***SET***' : 'NOT SET';
    
    $output = '<pre>Environment Check:<br><br>';
    $output .= '<strong>.env file location:</strong> ' . htmlspecialchars($envPath) . '<br>';
    $output .= '<strong>.env file exists:</strong> ' . ($envExists ? 'YES' : 'NO') . '<br>';
    $output .= '<strong>Config cached:</strong> ' . ($configCached ? 'YES (this prevents .env from being read!)' : 'NO') . '<br><br>';
    
    $output .= '<strong>From env() function:</strong><br>';
    $output .= 'DB_CONNECTION: ' . htmlspecialchars($dbConnectionEnv) . '<br>';
    $output .= 'DB_HOST: ' . htmlspecialchars($dbHostEnv) . '<br>';
    $output .= 'DB_DATABASE: ' . htmlspecialchars($dbDatabaseEnv) . '<br>';
    $output .= 'DB_USERNAME: ' . htmlspecialchars($dbUsernameEnv) . '<br>';
    $output .= 'DB_PASSWORD: ' . htmlspecialchars($dbPasswordEnv) . '<br><br>';
    
    $output .= '<strong>From config() function (what Laravel actually uses):</strong><br>';
    $output .= 'DB_HOST: ' . htmlspecialchars($dbHostConfig) . '<br>';
    $output .= 'DB_DATABASE: ' . htmlspecialchars($dbDatabaseConfig) . '<br>';
    $output .= 'DB_USERNAME: ' . htmlspecialchars($dbUsernameConfig) . '<br>';
    $output .= 'DB_PASSWORD: ' . htmlspecialchars($dbPasswordConfig) . '<br><br>';
    
    if ($configCached) {
        $output .= '<strong style="color: red;">WARNING: Config is cached! Clear it first with /clear-config</strong><br>';
    }
    
    $output .= '</pre>';
    
    return $output;
});


// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Settings
    Route::get('/profile/settings', [ProfileController::class, 'show'])->name('profile.settings');
    Route::put('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
        // Trade Plans
        Route::resource('trade-plans', TradePlanController::class);
        Route::patch('/trade-plans/{tradePlan}/status', [TradePlanController::class, 'updateStatus'])->name('trade-plans.update-status');
        Route::patch('/trade-plans/{tradePlan}/result', [TradePlanController::class, 'updateResult'])->name('trade-plans.update-result');

        // Trading Pairs Management
        Route::resource('trading-pairs', \App\Http\Controllers\TradingPairController::class);
        Route::patch('/trading-pairs/{tradingPair}/toggle-status', [\App\Http\Controllers\TradingPairController::class, 'toggleStatus'])->name('trading-pairs.toggle-status');
});
