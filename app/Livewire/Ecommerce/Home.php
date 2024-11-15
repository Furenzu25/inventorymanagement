<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
  

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

    public function editProfile()
    {
        return redirect()->route('profile');
    }

    public function addToCart()
    {
        $cart = session('cart', []);
        $product = $this->selectedProduct;
        $variant = $this->selectedVariant ? ProductVariant::find($this->selectedVariant) : null;
        
        $cartItemKey = $this->findCartItem($product->id, $this->selectedVariant);
        
        if ($cartItemKey !== false) {
            $cart[$cartItemKey]['quantity'] += $this->quantity;
        } else {
            $cart[] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $variant ? ($product->price + $variant->price_adjustment) : $product->price,
                'quantity' => $this->quantity,
                'variant_id' => $this->selectedVariant,
                'variant_name' => $variant ? $variant->name : null,
            ];
        }

        session(['cart' => $cart]);
        $this->updateCartCount();
        $this->dispatch('cart-updated');
        $this->showAddToCartModal = false;
    }

    private function findCartItem($productId, $variantId)
    {
        $cart = session('cart', []);
        foreach ($cart as $key => $item) {
            if ($item['id'] === $productId && $item['variant_id'] === $variantId) {
                return $key;
            }
        }
        return false;
    }
}
