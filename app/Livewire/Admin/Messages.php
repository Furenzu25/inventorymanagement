<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Messages extends Component
{
    public function mount()
    {
        if (!auth()->user()->is_admin) {
            return redirect()->route('messages');
        }
    }

    public function render()
    {
        return view('livewire.admin.messages')
            ->layout('components.layouts.app');
    }
} 