<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;

class Messages extends Component
{
    public function mount()
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.messages');
        }
    }

    public function render()
    {
        return view('livewire.ecommerce.messages')
            ->layout('layouts.ecommerce');
    }
} 