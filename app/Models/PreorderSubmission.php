<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Notifications\AdminPreorderNotification;
use App\Notifications\PreorderStatusNotification;

class PreorderSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'preorder_id',
        'customer_id',
        'total_amount',
        'status'
    ];

    protected static function booted()
    {
        static::created(function ($preorderSubmission) {
            // Notify admins about the preorder
            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new AdminPreorderNotification($preorderSubmission->preorder));
            }

            // Notify customer
            $customer = $preorderSubmission->customer;
            if ($customer && $customer->user) {
                $customer->user->notify(new PreorderStatusNotification(
                    $preorderSubmission->preorder,
                    'Preorder Submitted',
                    'Your preorder has been submitted and is pending review.'
                ));
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }
} 