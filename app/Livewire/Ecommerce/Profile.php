<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;

class Profile extends Component
{
    use WithFileUploads, WithCartCount, WithNotificationCount;

    public $validIdImage;
    public $profileImage;
    public $currentTab = 'profile';
    public $validIdProgress = false;
    public $profileProgress = false;
    public $customer = [
        'name' => '',
        'birthday' => '',
        'address' => '',
        'phone_number' => '',
        'reference_contactperson' => '',
        'reference_contactperson_phonenumber' => '',
        'email' => '',
        'valid_id' => '',
        'valid_id_image' => '',
        'profile_image' => '',
    ];

    public function mount()
    {
        if (Auth::user()->customer) {
            $this->customer = Auth::user()->customer->toArray();
        } else {
            $this->customer['email'] = Auth::user()->email;
            $this->customer['name'] = Auth::user()->name;
        }
    }

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function updatedValidIdImage()
    {
        $this->validateOnly('validIdImage', [
            'validIdImage' => 'image|max:5120'
        ]);
        
        $this->validIdProgress = true;
        
        try {
            if ($this->validIdImage instanceof TemporaryUploadedFile) {
                session()->flash('valid_id_message', 'Valid ID uploaded successfully!');
            }
        } finally {
            $this->validIdProgress = false;
        }
    }

    public function updatedProfileImage()
    {
        $this->validateOnly('profileImage', [
            'profileImage' => 'image|max:5120'
        ]);
        
        $this->profileProgress = true;
        
        try {
            if ($this->profileImage instanceof TemporaryUploadedFile) {
                session()->flash('profile_message', 'Profile picture uploaded successfully!');
            }
        } finally {
            $this->profileProgress = false;
        }
    }

    public function updateProfile()
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
            'validIdImage' => 'nullable|image|max:5120',
            'profileImage' => 'nullable|image|max:5120',
        ]);

        $customer = Auth::user()->customer;
        
        if (!$customer) {
            $customer = Auth::user()->createCustomerProfile($this->customer);
        } else {
            $customer->fill($this->customer);
        }

        if ($this->validIdImage) {
            if ($customer->valid_id_image) {
                Storage::disk('public')->delete($customer->valid_id_image);
            }
            $imagePath = $this->validIdImage->store('valid_ids', 'public');
            $customer->valid_id_image = $imagePath;
        }

        if ($this->profileImage) {
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            $imagePath = $this->profileImage->store('profile_images', 'public');
            $customer->profile_image = $imagePath;
        }

        $customer->save();
        session()->flash('message', 'Profile updated successfully!');
        
        // Redirect to home page
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.ecommerce.profile')
            ->layout('components.layouts.guest');
    }
}