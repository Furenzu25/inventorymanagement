<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $showEditProfileModal = false;

    protected $listeners = [
        'openEditProfileModal',
        'cart-updated' => 'updateCartCount',
        'profile-updated' => '$refresh'
    ];

    public $cart = [];
    public $cartCount = 0;

    public function editProfile()
    {
        $this->dispatch('openEditProfileModal');
    }

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

    public function openEditProfileModal()
    {
        $this->showEditProfileModal = true;
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session('cart', []);
        
        $existingItemKey = array_search($productId, array_column($cart, 'id'));
        
        if ($existingItemKey !== false) {
            $cart[$existingItemKey]['quantity']++;
        } else {
            $cart[] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);
        $this->updateCartCount();
        $this->dispatch('cart-updated');
    }

    public function getCartCountProperty()
    {
        return count($this->cart);
    }

    public function updateCartCount()
    {
        $cart = session('cart', []);
        $this->cartCount = array_sum(array_column($cart, 'quantity'));
    }

    public function mount()
    {
        $this->updateCartCount();
    }
}
