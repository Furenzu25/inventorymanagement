<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Preorder;

class Preorderitem extends Model
{
    use HasFactory;
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
