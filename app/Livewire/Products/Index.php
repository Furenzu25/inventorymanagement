<?php
namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    #[Rule('nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:5120')]
    public $search = '';
    public $sortBy = ['column' => 'product_name', 'direction' => 'asc'];
    public $modalOpen = false;
    public $productId;
    public $image; // The uploaded image file
    public $product = [
        'product_name' => '',
        'product_model' => '',
        'product_brand' => '',
        'product_category' => '',
        'product_description' => '',
        'price' => '',
        'storage_capacity' => '',
        'status' => 'active', // New status field (default to active)
        'image' => '', // Store the image path here
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max size
    ];

    public function create()
    {
        $this->resetProduct(); // Clear product form
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
            'status' => 'active', // Default to active status
            'image' => '', // Reset image path
        ];
        $this->image = null; // Reset file upload
        $this->imageUploaded = false;
    }

    public function updatedImage()
    {
        $this->imageUploaded = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false; // Close the modal
        $this->resetProduct(); // Optionally reset the form fields
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