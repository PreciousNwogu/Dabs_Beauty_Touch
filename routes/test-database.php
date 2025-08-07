<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Database connection test route
Route::get('/test-database', function () {
    try {
        // Test database connection
        $connection = DB::connection();
        $pdo = $connection->getPdo();
        
        // Get database info
        $databaseName = $connection->getDatabaseName();
        
        // Test a simple query
        $tables = DB::select('SHOW TABLES');
        $tableCount = count($tables);
        
        // Get MySQL version
        $version = DB::select('SELECT VERSION() as version')[0]->version;
        
        return response()->json([
            'success' => true,
            'message' => '✅ MySQL database connection successful!',
            'details' => [
                'database_name' => $databaseName,
                'mysql_version' => $version,
                'driver' => config('database.default'),
                'host' => config('database.connections.mysql.host'),
                'port' => config('database.connections.mysql.port'),
                'tables_count' => $tableCount,
                'connection_status' => 'Connected'
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '❌ Database connection failed: ' . $e->getMessage(),
            'error_details' => [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile()),
                'config' => [
                    'driver' => config('database.default'),
                    'host' => config('database.connections.mysql.host'),
                    'database' => config('database.connections.mysql.database'),
                    'port' => config('database.connections.mysql.port')
                ]
            ]
        ]);
    }
});
