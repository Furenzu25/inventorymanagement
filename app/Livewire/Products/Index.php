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
        'product_details' => '',
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
        'product.product_details' => 'required',
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
        $this->productId = $id;
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

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $message = 'Product updated successfully.';
        } else {
            $product = new Product();
            $message = 'Product created successfully.';
        }

        $product->fill($this->product);

        if ($this->image) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            try {
                $imagePath = $this->image->store('products', 'public');
                $product->image = $imagePath;
            } catch (\Exception $e) {
                session()->flash('error', 'Error uploading image: ' . $e->getMessage());
                return;
            }
        }

        try {
            $product->save();
            $this->modalOpen = false;
            $this->reset(['product', 'image', 'existingImage', 'imageUploaded', 'productId']);
            session()->flash('message', $message);
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving product: ' . $e->getMessage());
        }
    }

    public function resetProduct()
    {
        $this->productId = null;
        $this->product = [
            'product_name' => '',
            'product_model' => '',
            'product_brand' => '',
            'product_category' => '',
            'product_description' => '',
            'product_details' => '',
            'price' => '',
            'storage_capacity' => '',
            'status' => 'active',
            'image' => '',
        ];
        $this->image = null;
        $this->imageUploaded = false;
        $this->existingImage = null;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);
        $this->imageUploaded = true;
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
        return view('livewire.products.index', [
            'products' => Product::query()
                ->when($this->search, function($query) {
                    $query->where('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('product_model', 'like', '%' . $this->search . '%')
                        ->orWhere('product_brand', 'like', '%' . $this->search . '%');
                })
                ->paginate(10)
        ]);
    }
}
