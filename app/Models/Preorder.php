<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preorder extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';
    const STATUS_CONVERTED = 'converted';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'customer_id',
        'loan_duration',
        'total_amount',
        'status',
        'order_date',
        'monthly_payment',
        'interest_rate',
        'payment_method',
        'bought_location',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'bought_location' => 'string',
    ];

    // Add this line to make bought_location nullable
    protected $attributes = [
        'bought_location' => null,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function preorderItems()
    {
        return $this->hasMany(PreorderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'preorder_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
