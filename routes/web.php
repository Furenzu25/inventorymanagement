<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Livewire\Customers\Index;
use App\Http\Livewire\Products;


Volt::route('/', 'users.index');

Route::get('/customers', function () {
    return view('livewire.customers.index');
});

Route::get('/users', function () {
    return view('livewire.users.index');
});

Route::get('/products', function () {
    return view('livewire.products.index');
});