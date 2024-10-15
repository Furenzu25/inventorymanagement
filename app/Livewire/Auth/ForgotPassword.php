<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class ForgotPassword extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    public function forgotPassword()
    {
        $this->validate();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            ['email' => $this->email, 'token' => $token, 'created_at' => now()]
        );

        // Send email
        Mail::to($this->email)->send(new ResetPasswordMail($token));

        session()->flash('message', 'We have emailed your password reset link!');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest');
    }
}
