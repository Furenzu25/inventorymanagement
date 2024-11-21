<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $cartCount = 0;
    public $accountReceivables;
    protected $listeners = [
        'cart-updated' => 'updateCartCount',
        'profile-updated' => '$refresh',
    ];

    public function render()
    {
        $products = Product::take(6)->get();
        
        return view('livewire.ecommerce.home', ['products' => $products])
            ->layout('components.layouts.guest');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function updateCartCount()
    {
        $cart = session('cart', []);
        $this->cartCount = array_sum(array_column($cart, 'quantity'));
    }

    public function mount()
    {
        $this->updateCartCount();
        if (Auth::check()) {
            Auth::user()->load('customer');
            $this->accountReceivables = Auth::user()->customer?->accountReceivables ?? collect();
        }
    }

    public function editProfile()
    {
        return redirect()->route('profile');
    }

    public function getProductDetails($productId)
    {
        $product = Product::findOrFail($productId);
        return [
            'product_name' => $product->product_name,
            'product_model' => $product->product_model,
            'product_brand' => $product->product_brand,
            'product_category' => $product->product_category,
            'storage_capacity' => $product->storage_capacity,
            'product_description' => $product->product_description,
            'product_details' => $product->product_details
        ];
    }
}
