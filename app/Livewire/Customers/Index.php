<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $customer;
    public $modalOpen = false;

    protected $rules = [
        'customer.name' => 'required|string|max:255',
        'customer.age' => 'required|integer',
        'customer.address' => 'required|string|max:255',
        'customer.phone_number' => 'required|string|max:20',
        'customer.email' => 'required|email',
        'customer.valid_id' => 'required|string|max:255',
    ];

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.customers.index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        $this->customer = new Customer();
        $this->modalOpen = true;
    }

    public function store()
    {
        $this->validate();

        Customer::updateOrCreate(
            ['id' => $this->customer->id],
            $this->customer->toArray()
        );

        $this->modalOpen = false;
        $this->reset('customer');
    }

    public function edit(Customer $customer)
    {
        $this->customer = $customer;
        $this->modalOpen = true;
    }

    public function delete(Customer $customer)
    {
        $customer->delete();
    }
}
