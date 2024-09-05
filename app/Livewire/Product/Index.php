<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Preorder;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $product;
    public $modalOpen = false;

    protected $rules = [
        'product.name' => 'required|string|max:255',
        'product.model' => 'required|string|max:255',
        'product.brand' => 'required|string|max:255',
        'product.category' => 'required|string|max:255',
        'product.description' => 'required|string|max:255',
        'product.storage_capacity' => 'required|string|max:255',
        'product.price' => 'required|numeric',
    ];
    public function render()
    {
        $products = Product::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.product.index', [
            'products' => $products,
        ]);
    }
    public function create()
    {
        $this->product = new Product();
        $this->modalOpen = true;
    }

    public function store()
    {
        $this->validate();

        Product::updateOrCreate(
            ['id' => $this->product->id],
            $this->product->toArray()
        );

        $this->modalOpen = false;
        $this->reset('product');
    }

    public function edit(Product $product)
    {
        $this->product = $product;
        $this->modalOpen = true;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
    
}
