<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'color',
        'storage',
        'price_adjustment',
        'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}