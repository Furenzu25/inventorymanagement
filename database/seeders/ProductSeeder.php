<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the product-images directory exists
        if (!Storage::exists('public/product-images')) {
            Storage::makeDirectory('public/product-images');
        }

        $products = [
            [
                'product_name' => 'Honor 90',
                'product_model' => '90',
                'product_brand' => 'Honor',
                'product_description' => '200MP Portrait Camera, 6.7" Quad-Curved AMOLED Display',
                'product_details' => 'Features:
                    - 200MP Main Camera
                    - 6.7" AMOLED Display
                    - 12GB RAM + 512GB Storage
                    - 5000mAh Battery
                    - 66W SuperCharge',
                'product_category' => 'Smartphone',
                'price' => 24990.00,
                'storage_capacity' => '512GB',
                'image' => 'product-images/honor-90.jpg'
            ],
            [
                'product_name' => 'Samsung Galaxy J7 Prime',
                'product_model' => 'J7 Prime',
                'product_brand' => 'Samsung',
                'product_description' => '5.5" TFT display, 13MP main camera',
                'product_details' => 'Features:
                    - 13MP Main Camera
                    - 5.5" TFT Display
                    - 3GB RAM + 32GB Storage
                    - 3300mAh Battery
                    - Octa-core Processor',
                'product_category' => 'Smartphone',
                'price' => 12000.00,
                'storage_capacity' => '32GB',
                'image' => 'product-images/samsung-j7-prime.jpg'
            ],
            [
                'product_name' => 'iPhone 13',
                'product_model' => '13',
                'product_brand' => 'Apple',
                'product_description' => 'A15 Bionic chip, Dual 12MP camera system',
                'product_details' => 'Features:
                    - Dual 12MP Camera System
                    - 6.1" Super Retina XDR Display
                    - A15 Bionic Chip
                    - 128GB Storage
                    - Face ID
                    - 5G Capable',
                'product_category' => 'Smartphone',
                'price' => 44990.00,
                'storage_capacity' => '128GB',
                'image' => 'product-images/iphone-13.jpg'
            ],
            [
                'product_name' => 'Xiaomi Redmi Note 12',
                'product_model' => 'Note 12',
                'product_brand' => 'Xiaomi',
                'product_description' => '6.67" AMOLED DotDisplay, 50MP AI Triple Camera',
                'product_details' => 'Features:
                    - 50MP AI Triple Camera
                    - 6.67" AMOLED Display
                    - 8GB RAM + 128GB Storage
                    - 5000mAh Battery
                    - 33W Fast Charging',
                'product_category' => 'Smartphone',
                'price' => 8999.00,
                'storage_capacity' => '128GB',
                'image' => 'product-images/xiaomi-note-12.png'
            ]
        ];

        // Copy sample images from a local directory to storage
        foreach ($products as $product) {
            $imagePath = $product['image'];
            $sourceImage = database_path('seeders/sample-images/' . basename($imagePath));
            
            if (File::exists($sourceImage)) {
                Storage::disk('public')->put(
                    $imagePath,
                    File::get($sourceImage)
                );
            }
            
            Product::create($product);
        }
    }
} 