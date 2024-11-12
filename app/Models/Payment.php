<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_receivable_id',
        'amount_paid',
        'payment_date',
        'due_amount',
        'remaining_balance'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function accountReceivable()
    {
        return $this->belongsTo(AccountReceivable::class);
    }

    public function preorder()
    {
        return $this->accountReceivable->preorder();
    }

    public function customer()
    {
        return $this->accountReceivable->customer();
    }
}
