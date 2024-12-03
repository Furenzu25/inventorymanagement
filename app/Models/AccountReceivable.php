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
        'status',
        'loan_start_date',
        'loan_end_date'
    ];

    protected $casts = [
        'loan_start_date' => 'datetime',
        'loan_end_date' => 'datetime'
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

    public function updateStatus()
    {
        if ($this->remaining_balance <= 0) {
            $this->status = 'completed';
            
            // Update all inventory items for this preorder to stocked_out
            InventoryItem::where('preorder_id', $this->preorder_id)
                ->where('status', 'loaned')
                ->update([
                    'status' => 'stocked_out',
                    'stocked_out_date' => now(),
                    'updated_at' => now()
                ]);

            // Update preorder status to completed
            $this->preorder->update(['status' => 'completed']);

            // Create sale record if it doesn't exist
            if (!Sale::where('account_receivable_id', $this->id)->exists()) {
                $totalInterest = $this->total_paid - $this->total_amount;
                Sale::create([
                    'account_receivable_id' => $this->id,
                    'customer_id' => $this->customer_id,
                    'preorder_id' => $this->preorder_id,
                    'total_amount' => $this->total_paid,
                    'interest_earned' => $totalInterest,
                    'completion_date' => now(),
                    'payment_method' => 'Monthly Payment',
                    'status' => 'completed',
                    'type' => 'payment',
                    'notes' => 'Converted from Account Receivable #' . $this->id
                ]);
            }
        } else {
            $this->status = 'ongoing';
        }
        
        $this->save();
    }

    public function getNextPaymentDueDate()
    {
        if (!$this->loan_start_date) {
            return null;
        }

        $lastPayment = $this->payments()->latest('payment_date')->first();
        
        if ($lastPayment) {
            return $lastPayment->payment_date->addMonth();
        }
        
        // If no payments yet, return the first payment due date (1 month after loan start)
        return $this->loan_start_date->addMonth();
    }

    public function getTotalAmountWithInterest()
    {
        $interestAmount = $this->total_amount * ($this->interest_rate / 100);
        return $this->total_amount + $interestAmount;
    }

    public function getRemainingBalanceWithInterest()
    {
        $totalWithInterest = $this->getTotalAmountWithInterest();
        return $totalWithInterest - $this->total_paid;
    }
}

