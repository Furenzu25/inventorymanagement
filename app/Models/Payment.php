<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'preorder_id',
        'customer_id',
        'sale_id',
        'amount_paid',
        'payment_date',
        'due_amount'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function preorder()
    {
        return $this->belongsTo(Preorder::class)->with('preorderItems.product');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
