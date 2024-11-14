<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $showModal = false;
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile()
    {
        $this->validate();

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->showModal = false;
        session()->flash('message', 'Profile updated successfully.');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
