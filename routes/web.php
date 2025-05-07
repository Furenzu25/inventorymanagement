<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Preorders\Index as PreordersIndex;
use App\Livewire\AR\Index as ARIndex;
use App\Livewire\Payments\Index as PaymentsIndex;
use App\Livewire\Inventory\Index as InventoryIndex;
use App\Livewire\Payments\History;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Livewire\Ecommerce\Home as EcommerceHome;
use App\Livewire\Ecommerce\CustomerOrders;
use App\Livewire\Ecommerce\Profile;
use App\Livewire\Admin\AdminOrders;
use App\Livewire\Landing;
use App\Livewire\Customers\SubmitPayment;

// Debug route
Route::get('/debug', function () {
    $db_file = env('DB_DATABASE', database_path('database.sqlite'));
    
    return response()->json([
        'status' => 'OK',
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
        'environment' => app()->environment(),
        'debug' => config('app.debug'),
        'database_connection' => config('database.default'),
        'database_file' => $db_file,
        'database_file_exists' => file_exists($db_file),
        'database_file_writable' => is_writable($db_file),
        'storage_path' => storage_path(),
        'storage_path_exists' => is_dir(storage_path()),
        'storage_path_writable' => is_writable(storage_path()),
        'public_path' => public_path(),
        'public_path_exists' => is_dir(public_path()),
        'public_path_writable' => is_writable(public_path()),
        'bootstrap_cache_path' => base_path('bootstrap/cache'),
        'bootstrap_cache_exists' => is_dir(base_path('bootstrap/cache')),
        'bootstrap_cache_writable' => is_writable(base_path('bootstrap/cache')),
        'env_file_exists' => file_exists(base_path('.env')),
        'sqlite_extension_loaded' => extension_loaded('pdo_sqlite'),
    ]);
});

// Public routes
Route::get('/', function() {
    return view('welcome');
})->name('landing');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

// Authentication routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Your email has been verified. Please log in.');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('/sales', App\Livewire\Sales\Index::class)->name('sales.index');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/messages', \App\Livewire\Ecommerce\Messages::class)->name('messages');
});

// Protected routes (require auth and email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', EcommerceHome::class)->name('home');
    Route::get('/cart', \App\Livewire\Ecommerce\Cart::class)->name('cart');
    Route::get('/my-orders', CustomerOrders::class)->name('customer.orders');
    Route::get('/customer/payments', \App\Livewire\Customers\PaymentHistory::class)->name('customer.payments');
    Route::get('/profile', \App\Livewire\Ecommerce\Profile::class)->name('profile');
    Route::get('/customer/payments/submit', SubmitPayment::class)->name('payment.submit');

    // Admin routes
    Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)->name('dashboard');
        Route::get('/customers', CustomersIndex::class)->name('customers.index');
        Route::get('/products', ProductsIndex::class)->name('products.index');
        Route::get('/preorders', PreordersIndex::class)->name('preorders.index');
        Route::get('/ar', ARIndex::class)->name('ar.index');
        Route::get('/payments', PaymentsIndex::class)->name('payments.index');
        Route::get('/payments/history/{account_receivable?}', History::class)->name('payments.history');
        Route::get('/inventory', InventoryIndex::class)->name('inventory.index');
        Route::get('/admin/orders', AdminOrders::class)->name('admin.orders');
    });
});

// File download route
Route::get('/download/{filename}', function ($filename) {
    $path = 'C:/downloads/' . $filename;
    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404);
    }
});

Route::post('/email/resend', function (Request $request) {
    $user = $request->user();
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    $user->sendEmailVerificationNotification();

    return back()->with('resent', true);
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Admin messages route
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/messages', \App\Livewire\Admin\Messages::class)->name('admin.messages');
});

// Super simple test route - should work even if other routes fail
Route::get('/test', function () {
    return '<html><body><h1>Test Route Works!</h1><p>PHP Version: ' . phpversion() . '</p></body></html>';
});

// Fallback route for when everything else fails
Route::fallback(function () {
    return view('welcome');
});
