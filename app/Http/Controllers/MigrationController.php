<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationController extends Controller
{
    /**
     * Show migration index page.
     */
    public function index()
    {
        $token = request()->query('token');
        if ($token !== env('MIGRATION_TOKEN', 'your-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            Artisan::call('migrate:status');
            $status = Artisan::output();
            
            return response()->json([
                'success' => true,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Run all pending migrations.
     */
    public function runMigrations(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');
        if ($token !== env('MIGRATION_TOKEN', 'your-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Migrations completed successfully',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Run a specific migration.
     */
    public function runSpecificMigration(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');
        if ($token !== env('MIGRATION_TOKEN', 'your-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $migration = $request->input('migration');
        if (!$migration) {
            return response()->json([
                'success' => false,
                'error' => 'Migration name is required'
            ], 400);
        }

        try {
            Artisan::call('migrate', [
                '--path' => $migration,
                '--force' => true
            ]);
            $output = Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Migration completed successfully',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rollback migrations.
     */
    public function rollback(Request $request)
    {
        $token = $request->input('token') ?? $request->query('token');
        if ($token !== env('MIGRATION_TOKEN', 'your-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $steps = $request->input('steps', 1);

        try {
            Artisan::call('migrate:rollback', [
                '--step' => $steps,
                '--force' => true
            ]);
            $output = Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Rollback completed successfully',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get migration status.
     */
    public function getStatus()
    {
        $token = request()->query('token');
        if ($token !== env('MIGRATION_TOKEN', 'your-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            Artisan::call('migrate:status');
            $status = Artisan::output();
            
            return response()->json([
                'success' => true,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}