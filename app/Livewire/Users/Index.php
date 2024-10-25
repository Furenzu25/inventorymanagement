<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination; // Add pagination

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
    ];

    // Display the modal for creating or editing
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
        ];
        $this->customerId = null;
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
            'customer.name' => 'required|string|max:255',
            'customer.age' => 'required|integer',
            'customer.address' => 'required|string|max:255',
            'customer.phone_number' => 'required|string|max:20',
            'customer.email' => 'required|email|unique:customers,email,' . $this->customerId,
            'customer.valid_id' => 'required|string|max:255',
        ]);

        if ($this->customerId) {
            $customer = Customer::find($this->customerId);
            $customer->update($this->customer);
        } else {
            Customer::create($this->customer);
        }

        $this->reset();
        $this->modalOpen = false;
        session()->flash('message', $this->customerId ? 'Customer updated successfully.' : 'Customer created successfully.');
    }

    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
            ['key' => 'age', 'label' => 'Age', 'class' => 'w-20'],
            ['key' => 'address', 'label' => 'Address', 'class' => 'w-64'],
            ['key' => 'phone_number', 'label' => 'Phone Number', 'class' => 'w-32'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'w-64'],
            ['key' => 'valid_id', 'label' => 'Valid ID', 'class' => 'w-32'],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
        ];
    }

    public function render()
    {
        $customers = Customer::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10); // Adjust pagination as needed

        return view('livewire.users.index', [
            'customers' => $customers,
            'headers' => $this->headers(),
            'sortBy' => $this->sortBy,
        ]);
    }
}

