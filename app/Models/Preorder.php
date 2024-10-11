<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preorder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'loan_duration',
        'total_amount',
        'monthly_payment',
        'interest_rate',
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

    public function preorderItems()
    {
        return $this->hasMany(PreorderItem::class);
    }
}
