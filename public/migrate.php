<?php

/**
 * Standalone migration script
 * Usage: https://yourdomain.com/migrate.php
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
// Load .env file manually
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove quotes if present
            $value = trim($value, '"\'');
            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// Set session driver to array BEFORE Laravel loads
putenv('SESSION_DRIVER=array');
$_ENV['SESSION_DRIVER'] = 'array';

// Delete config cache file if it exists (might have old session driver cached)
$configCache = __DIR__ . '/../bootstrap/cache/config.php';
if (file_exists($configCache)) {
    @unlink($configCache);
}

// Bootstrap Laravel
define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Force session driver to array in config BEFORE anything else
$app['config']->set('session.driver', 'array');

// Also set it in the config array
config(['session.driver' => 'array']);

// Run migrations using Console Kernel (completely bypasses HTTP)
try {
    // Use Console Kernel instead of HTTP Kernel
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    
    // Bootstrap the console application
    $kernel->bootstrap();
    
    // Clear config cache
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    
    // Run migrations
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    
    echo '<pre>';
    echo 'Migrations completed successfully!<br><br>';
    echo htmlspecialchars($output);
    echo '</pre>';
} catch (\Exception $e) {
    // If it's a session error, try to continue anyway
    if (strpos($e->getMessage(), 'Session store not set') !== false) {
        // Try running migrations anyway
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $output = \Illuminate\Support\Facades\Artisan::output();
            echo '<pre>Migrations completed (session error ignored):<br><br>' . htmlspecialchars($output) . '</pre>';
        } catch (\Exception $e2) {
            echo '<pre>Error: ' . htmlspecialchars($e2->getMessage()) . '</pre>';
        }
    } else {
        echo '<pre>';
        echo 'Error: ' . htmlspecialchars($e->getMessage()) . '<br><br>';
        echo 'Stack trace:<br>';
        echo htmlspecialchars($e->getTraceAsString());
        echo '</pre>';
    }
} catch (\Throwable $e) {
    // Catch any fatal errors
    echo '<pre>';
    echo '<strong>Fatal Error:</strong><br>';
    echo 'Message: ' . htmlspecialchars($e->getMessage()) . '<br><br>';
    echo 'File: ' . htmlspecialchars($e->getFile()) . '<br>';
    echo 'Line: ' . $e->getLine() . '<br><br>';
    echo 'Stack trace:<br>';
    echo htmlspecialchars($e->getTraceAsString());
    echo '</pre>';
} catch (\Exception $e) {
    // Catch any other exceptions
    echo '<pre>';
    echo '<strong>Error:</strong><br>';
    echo 'Message: ' . htmlspecialchars($e->getMessage()) . '<br><br>';
    echo 'File: ' . htmlspecialchars($e->getFile()) . '<br>';
    echo 'Line: ' . $e->getLine() . '<br><br>';
    echo 'Stack trace:<br>';
    echo htmlspecialchars($e->getTraceAsString());
    echo '</pre>';
}
