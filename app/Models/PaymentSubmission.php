<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Notifications\NewPaymentSubmission;

class PaymentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'account_receivable_id',
        'amount',
        'due_amount',
        'payment_proof',
        'payment_date',
        'status',
        'rejection_reason'  // Add this
    ];

    protected $casts = [
        'payment_date' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function accountReceivable()
    {
        return $this->belongsTo(AccountReceivable::class);
    }

    public function afterCreate()
    {
        // Get all admin users
        $admins = User::where('is_admin', true)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new NewPaymentSubmission($this));
        }
    }
} 