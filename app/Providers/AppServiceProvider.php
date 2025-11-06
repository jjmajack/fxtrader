<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix Vite manifest path for production deployment (register early)
        if (app()->environment('production')) {
            // In production, public_html IS the public folder (no subdirectory)
            // Override public_path to return base_path in production
            $this->app->bind('path.public', function () {
                return base_path();
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix MySQL key length issue for older versions
        Schema::defaultStringLength(191);
        
        // Configure Vite for production deployment
        if (app()->environment('production')) {
            // Set Vite asset URL for production
            if (!env('VITE_ASSET_URL')) {
                $_ENV['VITE_ASSET_URL'] = '/build';
            }
            
            // Configure Vite build path - use base_path since public_html is root
            config([
                'vite.build_path' => 'build',
                'vite.manifest_path' => base_path('build'),
            ]);
            
            // Override Vite's manifest path resolution
            if (class_exists(\Illuminate\Foundation\Vite::class)) {
                $this->app->singleton('vite', function ($app) {
                    $vite = new \Illuminate\Foundation\Vite($app);
                    // Force Vite to use base_path for manifest in production
                    if (method_exists($vite, 'useManifestPath')) {
                        $vite->useManifestPath(base_path('build/manifest.json'));
                    }
                    return $vite;
                });
            }
        }
    }
}
