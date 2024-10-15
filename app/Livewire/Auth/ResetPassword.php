<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email' => 'required|email|exists:users',
        'password' => 'required|min:8|confirmed',
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email');
    }

    public function resetPassword()
    {
        $this->validate();

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $this->email,
                'token' => $this->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        User::where('email', $this->email)
            ->update(['password' => Hash::make($this->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $this->email])->delete();

        return redirect()->route('login')->with('message', 'Your password has been changed!');
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('components.layouts.guest');
    }
}
