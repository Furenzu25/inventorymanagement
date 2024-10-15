<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Preorders\Index as PreordersIndex;
use App\Livewire\Sales\Index as SalesIndex;
use App\Livewire\Payments\Index as PaymentsIndex;
use App\Livewire\Payments\History;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;

// Login route
Route::get('/login', Login::class)->name('login');

// Root route
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('/customers', CustomersIndex::class)->name('customers.index');
    Route::get('/products', ProductsIndex::class)->name('products.index');
    Route::get('/preorders', PreordersIndex::class)->name('preorders.index');
    Route::get('/sales', SalesIndex::class)->name('sales.index');
    Route::get('/payments', PaymentsIndex::class)->name('payments.index');
    Route::get('/payments/history/{sale?}', History::class)->name('payments.history');
});

Route::get('/download/{filename}', function ($filename) {
    $path = 'C:/downloads/' . $filename;
    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404);
    }
});

Route::get('/register', Register::class)->name('register');

Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
