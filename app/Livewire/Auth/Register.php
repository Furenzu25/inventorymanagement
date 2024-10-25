<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $birthday;
    public $address;
    public $phone_number;
    public $reference_contactperson;
    public $reference_contactperson_phonenumber;
    public $valid_id;
    public $valid_id_image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users|unique:customers',
        'password' => 'required|string|min:8|confirmed',
        'birthday' => 'required|date',
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'reference_contactperson' => 'required|string|max:255',
        'reference_contactperson_phonenumber' => 'required|string|max:20',
        'valid_id' => 'required|string|max:255',
        'valid_id_image' => 'required|image|max:5120', // 5MB Max
    ];

    public function register()
    {
        $this->validate();

        $validIdImagePath = $this->valid_id_image->store('valid_ids', 'public');

        $customer = Customer::create([
            'name' => $this->name,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'reference_contactperson' => $this->reference_contactperson,
            'reference_contactperson_phonenumber' => $this->reference_contactperson_phonenumber,
            'email' => $this->email,
            'valid_id' => $this->valid_id,
            'valid_id_image' => $validIdImagePath,
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'customer_id' => $customer->id,
        ]);

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.guest');
    }
}
