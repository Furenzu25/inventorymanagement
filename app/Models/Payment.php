<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_receivable_id',
        'amount_paid',
        'payment_date',
        'due_amount',
        'remaining_balance',
        'status',
        'void_reason'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2'
    ];

    public function accountReceivable()
    {
        return $this->belongsTo(AccountReceivable::class);
    }

    public function customer()
    {
        return $this->hasOneThrough(
            Customer::class,
            AccountReceivable::class,
            'id', // Foreign key on account_receivables table
            'id', // Foreign key on customers table
            'account_receivable_id', // Local key on payments table
            'customer_id' // Local key on account_receivables table
        );
    }

    public function calculateRemainingBalance()
    {
        $ar = $this->accountReceivable;
        $previousPayments = Payment::where('account_receivable_id', $this->account_receivable_id)
            ->where('id', '<', $this->id ?? PHP_INT_MAX)
            ->sum('amount_paid');
            
        return $ar->total_amount - ($previousPayments + $this->amount_paid);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $payment->remaining_balance = $payment->calculateRemainingBalance();
        });

        static::updating(function ($payment) {
            $payment->remaining_balance = $payment->calculateRemainingBalance();
        });
    }

    public function preorder()
    {
        return $this->accountReceivable->preorder();
    }

    public function reverse()
    {
        DB::transaction(function () {
            $ar = $this->accountReceivable;
            
            // Find the sale that corresponds to this payment
            $sale = Sale::where('account_receivable_id', $ar->id)
                       ->where('completion_date', '>=', $this->payment_date)
                       ->where('total_amount', '<=', $ar->total_paid)
                       ->first();

            // If a sale exists and this payment contributed to completing the AR, delete the sale
            if ($sale) {
                $sale->delete();
                
                // Update preorder status if needed
                if ($ar->preorder) {
                    $ar->preorder->update(['status' => 'converted']);
                }
                
                // Update inventory items back to available
                InventoryItem::where('preorder_id', $ar->preorder_id)
                    ->update(['status' => 'available']);
                    
                // Update AR status back to ongoing
                $ar->status = 'ongoing';
            }
            
            // Update AR balances
            $ar->total_paid -= $this->amount_paid;
            $ar->remaining_balance += $this->amount_paid;
            $ar->save();
            
            // Delete the payment
            $this->delete();
            
            // Recalculate remaining balances for subsequent payments
            $subsequentPayments = Payment::where('account_receivable_id', $ar->id)
                ->where('payment_date', '>', $this->payment_date)
                ->orderBy('payment_date')
                ->get();
                
            foreach ($subsequentPayments as $payment) {
                $payment->remaining_balance = $payment->calculateRemainingBalance();
                $payment->save();
            }
        });
    }
}
