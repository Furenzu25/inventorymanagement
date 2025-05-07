<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Health check route for monitoring and diagnostics
Route::get('/health', function () {
    try {
        // Check database connection
        $dbCheck = DB::connection()->getPdo() ? true : false;
    } catch (\Exception $e) {
        $dbCheck = false;
        $dbError = $e->getMessage();
    }

    try {
        // Check storage directory is writable
        $storageCheck = is_writable(storage_path()) ? true : false;
    } catch (\Exception $e) {
        $storageCheck = false;
        $storageError = $e->getMessage();
    }

    $health = [
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'environment' => app()->environment(),
        'app_debug' => config('app.debug'),
        'database' => $dbCheck ? 'connected' : 'error: ' . ($dbError ?? 'unknown error'),
        'storage' => $storageCheck ? 'writable' : 'error: ' . ($storageError ?? 'not writable'),
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
    ];

    return response()->json($health);
});
