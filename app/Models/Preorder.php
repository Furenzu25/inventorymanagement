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
    const STATUS_DISAPPROVED = 'disapproved';

    // Add payment method constants
    const PAYMENT_METHOD_CARD = 'Card';
    const PAYMENT_METHOD_CASH = 'Cash';
    const PAYMENT_METHOD_BANK_TRANSFER = 'Bank Transfer';

    public static function getPaymentMethods()
    {
        return [
            self::PAYMENT_METHOD_CARD => 'Card',
            self::PAYMENT_METHOD_CASH => 'Cash',
            self::PAYMENT_METHOD_BANK_TRANSFER => 'Bank Transfer',
        ];
    }

    protected $fillable = [
        'customer_id',
        'loan_duration',
        'bought_location',
        'status',
        'payment_method',
        'order_date',
        'total_amount',
        'monthly_payment',
        'interest_rate',
        'disapproval_reason',
        'cancellation_reason'
    ];

    protected $casts = [
        'order_date' => 'date'
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
