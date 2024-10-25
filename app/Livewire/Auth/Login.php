<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PendingUser;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $message = '';
    public $loginError = '';
    public $status = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        $this->message = session('message');
        $this->status = session('status');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            if ($user->hasVerifiedEmail()) {
                return $user->isAdmin() 
                    ? redirect()->intended('/dashboard') 
                    : redirect()->intended('/home');
            } else {
                Auth::logout();
                return redirect()->route('verification.notice');
            }
        }

        $this->loginError = 'Invalid email or password.';
        $this->password = '';
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
