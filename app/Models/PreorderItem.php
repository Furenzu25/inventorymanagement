<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Product;
use App\Models\Preorder;

class PreorderItem extends Pivot
{
    protected $table = 'preorder_items';

    protected $fillable = [
        'preorder_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
