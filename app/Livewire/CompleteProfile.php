<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Customer;

class CompleteProfile extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $birthday;
    public $address;
    public $phone_number;
    public $reference_contactperson;
    public $reference_contactperson_phonenumber;
    public $valid_id;
    public $valid_id_image;

    protected $rules = [
        'birthday' => 'required|date',
        'address' => 'required|string',
        'phone_number' => 'required|string',
        'reference_contactperson' => 'required|string',
        'reference_contactperson_phonenumber' => 'required|string',
        'valid_id' => 'required|string',
        'valid_id_image' => 'required|image|max:5120',
    ];

    public function mount()
    {
        if (auth()->check() && !auth()->user()->customer) {
            $this->showModal = true;
        }
    }

    public function completeProfile()
    {
        $this->validate();
        
        $validIdImagePath = $this->valid_id_image->store('valid_ids', 'public');
        
        $customer = Customer::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'reference_contactperson' => $this->reference_contactperson,
            'reference_contactperson_phonenumber' => $this->reference_contactperson_phonenumber,
            'valid_id' => $this->valid_id,
            'valid_id_image' => $validIdImagePath,
        ]);

        auth()->user()->update(['customer_id' => $customer->id]);
        
        $this->showModal = false;
        $this->dispatch('profile-completed');
    }

    public function skip()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.complete-profile');
    }
} 