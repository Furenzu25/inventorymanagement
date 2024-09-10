<?php

namespace App\Livewire\Preorders;

use Livewire\Component;
use App\Models\Preorder;
use App\Models\Customer;
use App\Models\Product;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = ['column' => 'order_date', 'direction' => 'desc'];
    public $modalOpen = false;
    public $preorderId;
    public $preorder = [
        'customer_id' => '',
        'product_id' => '',
        'loan_duration' => '',
        'quantity' => '',
        'price' => '',
        'bought_location' => '',
        'status' => '',
        'payment_method' => '',
        'order_date' => '',
    ];
    public $customers;
    public $products;

    public function create()
    {
        $this->resetPreorder();
        $this->preorderId = null;
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->preorder = Preorder::findOrFail($id)->toArray();
        $this->preorderId = $id;
        $this->modalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'preorder.customer_id' => 'required|exists:customers,id',
            'preorder.product_id' => 'required|exists:products,id',
            'preorder.price' => 'required|numeric|min:0',
            // ... other validation rules ...
        ]);

        if (isset($this->preorder['id'])) {
            // Editing existing preorder
            $preorder = Preorder::findOrFail($this->preorder['id']);
            $preorder->update($this->preorder);
            session()->flash('message', 'Preorder updated successfully.');
        } else {
            // Creating new preorder
            Preorder::create($this->preorder);
            session()->flash('message', 'Preorder created successfully.');
        }

        $this->reset(['preorder']);
        $this->modalOpen = false;
    }

    public function delete($id)
    {
        Preorder::findOrFail($id)->delete();
        session()->flash('message', 'Pre-order deleted successfully.');
    }

    public function resetPreorder()
    {
        $this->preorder = [
            'customer_id' => '',
            'product_id' => '',
            'loan_duration' => '',
            'quantity' => '',
            'price' => '',
            'bought_location' => '',
            'status' => '',
            'payment_method' => '',
            'order_date' => Carbon::now()->format('Y-m-d'),
        ];
    }

    public function render()
    {
        $preorders = Preorder::with(['customer', 'product'])
            ->where(function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.preorders.index', [
            'preorders' => $preorders,
            'customers' => Customer::all(),
            'products' => Product::all(),
        ]);
    }

    public function headers(): array
    {
        return [
            ['key' => 'customer.name', 'label' => 'Customer', 'sortable' => true],
            ['key' => 'product.product_name', 'label' => 'Product', 'sortable' => true],
            ['key' => 'loan_duration', 'label' => 'Loan Duration', 'sortable' => true],
            ['key' => 'quantity', 'label' => 'Quantity', 'sortable' => true],
            ['key' => 'price', 'label' => 'Price', 'sortable' => true],
            ['key' => 'bought_location', 'label' => 'Bought Location', 'sortable' => true],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true],
            ['key' => 'payment_method', 'label' => 'Payment Method', 'sortable' => true],
            ['key' => 'order_date', 'label' => 'Order Date', 'sortable' => true],
        ];
    }

    public function mount()
    {
        $this->loadCustomersAndProducts();
    }

    public function loadCustomersAndProducts()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();
    }

    public function updatedPreorderCustomerId($value)
    {
        $this->preorder['customer_id'] = $value;
    }

    public function updatedPreorderProductId($value)
    {
        if ($value) {
            $product = Product::find($value);
            if ($product) {
                $this->preorder['price'] = $product->price;
            }
        } else {
            $this->preorder['price'] = '';
        }
    }
}
