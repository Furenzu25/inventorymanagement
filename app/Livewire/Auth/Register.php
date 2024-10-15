<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users|unique:pending_users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $verificationToken = Str::random(64);

        $pendingUser = PendingUser::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'verification_token' => $verificationToken,
        ]);

        Mail::to($this->email)->send(new VerifyEmail($pendingUser, $verificationToken));

        session()->flash('message', 'Please check your email to verify your account.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest');
    }
}
