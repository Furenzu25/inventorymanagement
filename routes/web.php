<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Preorders\Index as PreordersIndex;
use App\Livewire\Sales\Index as SalesIndex;
use Illuminate\Support\Facades\File;
use App\Livewire\Payments\Index as PaymentsIndex;
use App\Livewire\Payments\History;

// Main dashboard route using Volt
Volt::route('/', 'dashboard.index')->name('dashboard.index');
Route::get('/customers', CustomersIndex::class)->name('customers.index');
Route::get('/products', ProductsIndex::class)->name('products.index');
Route::get('/preorders', PreordersIndex::class)->name('preorders.index');
Route::get('/sales', SalesIndex::class)->name('sales.index');
Route::get('/download/{filename}', function ($filename) {
    $path = 'C:/downloads/' . $filename;

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404);
    }
});

Route::get('/payments', PaymentsIndex::class)->name('payments.index');

Route::get('/payments/history/{sale?}', History::class)->name('payments.history');
