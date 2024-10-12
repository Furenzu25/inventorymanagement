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
        'total_amount',
        'payment_months',
        'interest_rate',
        'status', // Add this new field
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

    public function updatePayment($amount)
    {
        $this->total_paid += $amount;
        $this->remaining_balance -= $amount;
        $this->checkAndUpdateStatus();
        $this->save();
    }

    public function checkAndUpdateStatus()
    {
        if ($this->remaining_balance <= 0) {
            $this->status = 'paid';
        } else {
            $this->status = 'ongoing';
        }
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

