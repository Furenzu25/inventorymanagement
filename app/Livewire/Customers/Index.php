<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Rule('nullable|image|max:5120')] // 5MB Max
    public $validIdImage;

    public $search = '';
    public $drawer = false;
    public $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public $modalOpen = false;
    public $customerId;

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
        'created_at' => '', // Store creation date
    ];

    public $editReason = ''; // Reason for editing

    public $showImagePreview = false;

    // Restrict access to creating customers unless authorized

    public $imageUploaded = false;

    public $selectedImage = null;

    public function create()
    {
        $this->customer = [
            'name' => '',
            'birthday' => '',
            'address' => '',
            'phone_number' => '',
            'reference_contactperson' => '',
            'reference_contactperson_phonenumber' => '',
            'email' => '',
            'valid_id' => '',
            'valid_id_image' => '',
            'created_at' => now(), // Capture creation date
        ];

        $this->customerId = null;
        $this->validIdImage = null;
        $this->modalOpen = true;
        $this->imageUploaded = false;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $customer = Customer::findOrFail($id);
        $this->customer = $customer->toArray();
        $this->customerId = $id;
        $this->modalOpen = true;
        $this->imageUploaded = false;

        // Request the user to provide a reason for editing
        session()->flash('info', 'Please provide a valid reason for editing.');
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        session()->flash('message', 'Customer deleted successfully.');
    }

    public function store()
    {
        $this->validate();

        if ($this->customerId) {
            $customer = Customer::findOrFail($this->customerId);
            $customer->update($this->customer);
            $message = 'Customer updated successfully.';
        } else {
            $customer = Customer::create($this->customer);
            $message = 'Customer created successfully.';
        }

        if ($this->validIdImage) {
            $imagePath = $this->validIdImage->store('valid_ids', 'public');
            $customer->valid_id_image = $imagePath;
            $customer->save();
        }

        $this->modalOpen = false;
        $this->reset(['customer', 'customerId', 'validIdImage', 'editReason', 'imageUploaded']);
        session()->flash('message', $message);
    }

    public function updatedValidIdImage()
    {
        $this->validate([
            'validIdImage' => 'image|max:5120', // 5MB Max
        ]);

        $this->imageUploaded = true;
    }

    public function removeImage()
    {
        $this->validIdImage = null;
        $this->customer['valid_id_image'] = null;
        $this->imageUploaded = false;
    }

    public function showImagePreview()
    {
        $this->showImagePreview = true;
    }

    public function hideImagePreview()
    {
        $this->showImagePreview = false;
    }

    public function showExpandedImage($imagePath)
    {
        $this->selectedImage = $imagePath;
    }

    public function closeExpandedImage()
    {
        $this->selectedImage = null;
    }

    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name', 'class' => 'w-32'],
            ['key' => 'birthday', 'label' => 'Birthday', 'class' => 'w-32'],
            ['key' => 'address', 'label' => 'Address', 'class' => 'w-32'],
            ['key' => 'phone_number', 'label' => 'Phone Number', 'class' => 'w-32'],
            ['key' => 'reference_contactperson', 'label' => 'Reference Contact Person', 'class' => 'w-32'],
            ['key' => 'reference_contactperson_phonenumber', 'label' => 'Reference # of Contact Person', 'class' => 'w-32'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'w-32'],
            ['key' => 'valid_id', 'label' => 'Valid ID #', 'class' => 'w-32'],
            ['key' => 'valid_id_image', 'label' => 'Valid ID Image', 'class' => 'w-32'],
            ['key' => 'created_at', 'label' => 'Profile Created', 'class' => 'w-32'], // Profile creation date
        ];
    }

    public function logActivity($message)
    {
        // Example log to track activity
        Log::info($message);
    }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.customers.index', [
            'customers' => $customers,
            'headers' => $this->headers(),
        ]);
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset(['customer', 'customerId', 'validIdImage', 'editReason', 'imageUploaded']);
    }

    protected function rules()
    {
        return [
            'customer.name' => 'required|string|max:255',
            'customer.birthday' => 'required|date',
            'customer.address' => 'required|string',
            'customer.phone_number' => 'required|string|max:20',
            'customer.reference_contactperson' => 'required|string|max:255',
            'customer.reference_contactperson_phonenumber' => 'required|string|max:20',
            'customer.email' => 'required|email|max:255',
            'customer.valid_id' => 'required|string|max:255',
            'validIdImage' => 'nullable|image|max:5120', // 5MB Max
        ];
    }

    protected function messages()
    {
        return [
            'customer.name.required' => 'The customer name is required.',
            // Add more custom messages here...
        ];
    }

    protected function validationAttributes()
    {
        return [
            'customer.name' => 'customer name',
            'customer.birthday' => 'birthday',
            // Add more custom attribute names here...
        ];
    }
}
