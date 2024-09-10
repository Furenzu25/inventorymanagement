<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = ['column' => 'product_name', 'direction' => 'asc'];
    public $modalOpen = false;
    public $productId;
    public $product = [
        'product_name' => '',
        'product_model' => '',
        'product_brand' => '',
        'product_category' => '',
        'product_description' => '',
        'price' => '',
        'storage_capacity' => '',
    ];

    protected $rules = [
        'product.storage_capacity' => 'required',
        // ... other rules
    ];

    public function create()
    {
        $this->product = [
            'product_name' => '',
            'product_model' => '',
            'product_brand' => '',
            'product_category' => '',
            'product_description' => '',
            'price' => '',
            'storage_capacity' => '',
        ];
        $this->productId = null;
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->product = Product::findOrFail($id)->toArray();
        $this->productId = $id;
        $this->modalOpen = true;
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function store()
    {
        $this->validate([
            'product.product_name' => 'required|string|max:255',
            'product.product_model' => 'required|string|max:255',
            'product.product_brand' => 'required|string|max:255',
            'product.product_category' => 'required|string|max:255',
            'product.product_description' => 'required|string',
            'product.storage_capacity' => 'required|string',
            'product.price' => 'required|numeric|min:0',
        ]);

        if (isset($this->productId)) {
            $product = Product::findOrFail($this->productId);
            $product->update($this->product);
            session()->flash('message', 'Product updated successfully.');
        } else {
            Product::create($this->product);
            session()->flash('message', 'Product created successfully.');
        }

        $this->reset(['product', 'productId']);
        $this->modalOpen = false;
    }

    public function headers()
    {
        return [
            ['key' => 'product_name', 'label' => 'Name', 'class' => 'w-32'],
            ['key' => 'product_model', 'label' => 'Model', 'class' => 'w-32'],
            ['key' => 'product_brand', 'label' => 'Brand', 'class' => 'w-32'],
            ['key' => 'product_category', 'label' => 'Category', 'class' => 'w-32'],
            ['key' => 'product_description', 'label' => 'Description', 'class' => 'w-32'],
            ['key' => 'storage_capacity', 'label' => 'Storage Capacity', 'class' => 'w-32'],
            ['key' => 'price', 'label' => 'Price', 'class' => 'w-32'],
        ];
    }

    public function render()
    {
        $query = Product::query()
            ->where('product_name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        $products = $query->paginate(10);

        return view('livewire.products.index', [
            'products' => $products,
            'headers' => $this->headers(),
            'sortBy' => $this->sortBy,
        ]);
    }

    public function updatedSortBy($value)
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sortBy['column'] === $column) {
            $this->sortBy['direction'] = $this->sortBy['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy['column'] = $column;
            $this->sortBy['direction'] = 'asc';
        }
        $this->resetPage();
    }

    public function updatedProductStorageCapacity($value)
    {
        $this->product['storage_capacity'] = $value;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset(['product', 'productId']);
    }
}
