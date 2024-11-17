<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class Landing extends Component
{
    public function render()
    {
        $products = Product::orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        return view('livewire.landing', [
            'products' => $products
        ])->layout('components.layouts.guest');
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