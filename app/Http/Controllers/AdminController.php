<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Simply return the view, Livewire will handle the rest
        return view('livewire.dashboard.index');
    }
}
