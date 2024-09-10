<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        'age' => '',
        'address' => '',
        'phone_number' => '',
        'email' => '',
        'valid_id' => '',
        'valid_id_image' => '',
    ];

    public $showImagePreview = false;

    public function create()
    {
        $this->customer = [
            'name' => '',
            'age' => '',
            'address' => '',
            'phone_number' => '',
            'email' => '',
            'valid_id' => '',
            'valid_id_image' => '',
        ];
        $this->customerId = null;
        $this->validIdImage = null;
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->customer = Customer::findOrFail($id)->toArray();
        $this->customerId = $id;
        $this->modalOpen = true;
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        session()->flash('message', 'Customer deleted successfully.');
    }

    public function store()
    {
        $this->validate([
            'customer.name' => 'required',
            'customer.age' => 'required|numeric',
            'customer.address' => 'required',
            'customer.phone_number' => 'required',
            'customer.email' => 'required|email',
            'customer.valid_id' => 'required',
            'validIdImage' => 'nullable|image|max:5120', // 5MB Max
        ]);

        if ($this->customerId) {
            // Update existing customer
            $customer = Customer::find($this->customerId);
            $customer->update($this->customer);
        } else {
            // Create new customer
            $customer = Customer::create($this->customer);
        }

        // Handle file upload
        if ($this->validIdImage) {
            $imagePath = $this->validIdImage->store('valid_ids', 'public');
            $customer->valid_id_image = $imagePath;
            $customer->save();
        }

        $this->modalOpen = false;
        $this->reset(['customer', 'customerId', 'validIdImage']);
        session()->flash('message', 'Customer updated successfully.');
    }

    public function updatedValidIdImage()
    {
        $this->validate([
            'validIdImage' => 'image|max:5120', // 5MB Max
        ]);
    }

    public function removeImage()
    {
        $this->validIdImage = null;
        $this->customer['valid_id_image'] = null;
    }

    public function showImagePreview()
    {
        $this->showImagePreview = true;
    }

    public function hideImagePreview()
    {
        $this->showImagePreview = false;
    }

    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name', 'class' => 'w-32'],
            ['key' => 'age', 'label' => 'Age', 'class' => 'w-32'],
            ['key' => 'address', 'label' => 'Address', 'class' => 'w-32'],
            ['key' => 'phone_number', 'label' => 'Phone Number', 'class' => 'w-32'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'w-32'],
            ['key' => 'valid_id', 'label' => 'Valid ID #', 'class' => 'w-32'],
            ['key' => 'valid_id_image', 'label' => 'Valid ID Image', 'class' => 'w-32'],
        ];
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
            'headers' => $this->headers(), // Add this line
        ]);
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset(['customer', 'customerId', 'validIdImage']);
    }
}