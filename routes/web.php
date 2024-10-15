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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerifyEmailController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});
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
    })->middleware('auth')->name('verification.notice');

    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
});

// Email verification route
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// Protected routes (require auth and email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('/customers', CustomersIndex::class)->name('customers.index');
    Route::get('/products', ProductsIndex::class)->name('products.index');
    Route::get('/preorders', PreordersIndex::class)->name('preorders.index');
    Route::get('/sales', SalesIndex::class)->name('sales.index');
    Route::get('/payments', PaymentsIndex::class)->name('payments.index');
    Route::get('/payments/history/{sale?}', History::class)->name('payments.history');
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
