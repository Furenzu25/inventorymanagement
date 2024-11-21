<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariant;

class AddToCartModal extends Component
{
    public $showModal = false;
    public $product = null;
    public $quantity = 1;
    public $selectedVariant = null;

    protected $listeners = [
        'openModal' => 'handleOpenModal'
    ];

    public function handleOpenModal(...$args)
    {
        $productId = $args[0];
        $this->product = Product::with('variants')->find($productId);
        $this->showModal = true;
        $this->quantity = 1;
        $this->selectedVariant = null;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['product', 'quantity', 'selectedVariant']);
    }

    public function addToCart()
    {
        if (!$this->product) return;

        $cart = session()->get('cart', []);
        $variant = $this->selectedVariant ? ProductVariant::find($this->selectedVariant) : null;
        
        $cartItemKey = $this->findCartItem($this->product->id, $this->selectedVariant);
        
        if ($cartItemKey !== false) {
            $cart[$cartItemKey]['quantity'] += $this->quantity;
        } else {
            $cart[] = [
                'id' => $this->product->id,
                'name' => $this->product->product_name,
                'price' => $variant ? ($this->product->price + $variant->price_adjustment) : $this->product->price,
                'quantity' => $this->quantity,
                'variant_id' => $this->selectedVariant,
                'variant_name' => $variant ? $variant->name : null,
            ];
        }

        session(['cart' => $cart]);
        
        // Dispatch both events
        $this->dispatch('cart-updated');
        $this->dispatch('notify', [
            'message' => 'Product added to cart successfully!',
            'type' => 'success'
        ]);
        
        $this->closeModal();
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

    public function render()
    {
        return view('livewire.ecommerce.add-to-cart-modal');
    }
}