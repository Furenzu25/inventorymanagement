<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountReceivable extends Model
{
    use HasFactory;

    protected $table = 'account_receivables';

    protected $fillable = [
        'preorder_id',
        'customer_id',
        'monthly_payment',
        'total_paid',
        'remaining_balance',
        'total_amount',
        'payment_months',
        'interest_rate',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function calculateMonthlyPayment()
    {
        // If there's no interest, use simple division
        if ($this->interest_rate == 0) {
            $this->monthly_payment = $this->total_amount / $this->payment_months;
        } else {
            // Use the formula for monthly payments with interest
            $r = $this->interest_rate / 12 / 100; // Monthly interest rate
            $n = $this->payment_months; // Total number of payments
            $p = $this->total_amount; // Principal amount

            $this->monthly_payment = ($p * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);
        }

        $this->save();

        return $this->monthly_payment;
    }
}

