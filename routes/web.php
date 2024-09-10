<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Preorders\Index as PreordersIndex;


// Main dashboard route using Volt
Volt::route('/', 'dashboard.index')->name('dashboard.index');
Route::get('/customers', CustomersIndex::class)->name('customers.index');
Route::get('/products', ProductsIndex::class)->name('products.index');
Route::get('/preorders', PreordersIndex::class)->name('preorders.index');

