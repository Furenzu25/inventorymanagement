<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'preorder_id',
        'customer_id',
        'monthly_payment',
        'total_paid',
        'remaining_balance',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }

    public function calculateMonthlyPayment()
    {
        // Implement logic to calculate monthly payment
    }

    public function updatePayment($amount)
    {
        $this->total_paid += $amount;
        $this->remaining_balance -= $amount;
        $this->save();
    }
}
