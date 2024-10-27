<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortBy = ['column' => 'product_name', 'direction' => 'asc'];
    public $modalOpen = false;
    public $productId;
    public $image;
    public $productDetailsOpen = false;
    public $selectedProduct = null;
    public $product = [
        'product_name' => '',
        'product_model' => '',
        'product_brand' => '',
        'product_category' => '',
        'product_description' => '',
        'price' => '',
        'storage_capacity' => '',
        'status' => 'active',
        'image' => '',
    ];
    public $oldImage;
    public $existingImage;
    public $imageUploaded = false;

    protected $rules = [
        'product.product_name' => 'required',
        'product.product_model' => 'required',
        'product.product_brand' => 'required',
        'product.product_category' => 'required',
        'product.product_description' => 'required',
        'product.storage_capacity' => 'required',
        'product.price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ];

    public function create()
    {
        $this->resetProduct();
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $product = Product::findOrFail($id);
        $this->product = $product->toArray();
        $this->existingImage = $product->image;
        $this->modalOpen = true;
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function store()
    {
        $this->validate();

        // Ensure price is a float
        $this->product['price'] = (float) $this->product['price'];

        if (isset($this->product['id'])) {
            $product = Product::findOrFail($this->product['id']);
            $message = 'Product updated successfully.';
        } else {
            $product = new Product();
            $message = 'Product created successfully.';
        }

        $product->fill($this->product);

        if ($this->image) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $this->image->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        $this->modalOpen = false;
        $this->reset(['product', 'image', 'existingImage', 'imageUploaded']);
        session()->flash('message', $message);
    }

    public function resetProduct()
    {
        $this->product = [
            'product_name' => '',
            'product_model' => '',
            'product_brand' => '',
            'product_category' => '',
            'product_description' => '',
            'price' => '',
            'storage_capacity' => '',
            'status' => 'active',
            'image' => '',
        ];
        $this->image = null;
        $this->imageUploaded = false;
    }

    public function updatedImage()
    {
        $this->imageUploaded = true;
        session()->flash('message', 'Image uploaded successfully.');
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetProduct();
    }

    public function showProductDetails($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->productDetailsOpen = true;
    }

    public function render()
    {
        $products = Product::where('product_name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.products.index', [
            'products' => $products
        ]);
    }
}
