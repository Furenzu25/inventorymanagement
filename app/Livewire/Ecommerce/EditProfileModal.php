<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class EditProfileModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $validIdImage;
    public $customer = [
        'name' => '',
        'birthday' => '',
        'address' => '',
        'phone_number' => '',
        'reference_contactperson' => '',
        'reference_contactperson_phonenumber' => '',
        'email' => '',
        'valid_id' => '',
    ];

    protected $listeners = ['openEditProfileModal' => 'open'];

    public function mount()
    {
        if (Auth::user()->customer) {
            $this->customer = Auth::user()->customer->toArray();
        } else {
            $this->customer['email'] = Auth::user()->email;
            $this->customer['name'] = Auth::user()->name;
        }
    }

    public function open()
    {
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate([
            'customer.name' => 'required|string|max:255',
            'customer.birthday' => 'required|date',
            'customer.address' => 'required|string|max:255',
            'customer.phone_number' => 'required|string|max:255',
            'customer.reference_contactperson' => 'required|string|max:255',
            'customer.reference_contactperson_phonenumber' => 'required|string|max:255',
            'customer.email' => 'required|string|email|max:255',
            'customer.valid_id' => 'required|string|max:255',
        ]);

        $customer = Auth::user()->customer;
        $customer->name = $this->customer['name'];
        $customer->birthday = $this->customer['birthday'];
        $customer->address = $this->customer['address'];
        $customer->phone_number = $this->customer['phone_number'];
        $customer->reference_contactperson = $this->customer['reference_contactperson'];
        $customer->reference_contactperson_phonenumber = $this->customer['reference_contactperson_phonenumber'];
        $customer->email = $this->customer['email'];
        $customer->valid_id = $this->customer['valid_id'];
        $customer->save();

        $this->close();
    }
} 