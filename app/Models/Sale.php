<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = [
        'account_receivable_id',
        'customer_id',
        'preorder_id',
        'total_amount',
        'interest_earned',
        'completion_date',
        'payment_method',
        'status',
        'notes'
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function accountReceivable(): BelongsTo
    {
        return $this->belongsTo(AccountReceivable::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function preorder(): BelongsTo
    {
        return $this->belongsTo(Preorder::class);
    }
} 