<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'product_id',
        'serial_number',
        'status',
        'preorder_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }
}
