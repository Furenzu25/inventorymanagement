<?php

use Illuminate\Http\Request;

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the application start time
define('LARAVEL_START', microtime(true));

// Check if the autoloader exists
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Composer autoloader not found. Please run "composer install".');
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

try {
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    
    // Display a user-friendly error page
    echo '<html><head><title>Application Error</title>';
    echo '<style>body{font-family:Arial,sans-serif;line-height:1.6;color:#333;max-width:800px;margin:0 auto;padding:20px}h1{color:#e74c3c}pre{background:#f8f8f8;padding:15px;overflow:auto;border-radius:3px}</style>';
    echo '</head><body>';
    echo '<h1>Application Error</h1>';
    echo '<p>The application encountered an error. Please try again later.</p>';
    
    // Only show detailed error in debug mode
    echo '<h2>Error Details:</h2>';
    echo '<pre>' . $e->getMessage() . '</pre>';
    echo '<h3>Stack Trace:</h3>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
    
    echo '</body></html>';
}
