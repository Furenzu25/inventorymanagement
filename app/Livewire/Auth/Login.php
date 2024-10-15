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

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        $this->message = session('message');
    }

    public function login()
    {
        $this->validate();

        $pendingUser = PendingUser::where('email', $this->email)->first();

        if ($pendingUser) {
            $this->addError('email', 'Please verify your email address. Check your inbox for the verification link.');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            if ($user->email_verified_at) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('verification.notice');
            }
        }

        $this->addError('email', trans('auth.failed'));
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
