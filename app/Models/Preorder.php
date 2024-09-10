<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preorder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'loan_duration',
        'quantity',
        'price',
        'bought_location',
        'status',
        'payment_method',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
