<?php

namespace App\Services;

use App\Models\Preorder;
use App\Models\AccountReceivable;
use App\Models\User;
use App\Notifications\PreorderStatusNotification;
use App\Notifications\PaymentDueNotification;
use App\Notifications\LowInventoryNotification;
use App\Models\CustomerNotification;

class NotificationService
{
    // Admin notifications
    public static function preorderCreated(Preorder $preorder)
    {
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new PreorderStatusNotification(
                $preorder,
                'New Preorder',
                "New preorder #{$preorder->id} created by {$preorder->customer->name}"
            ));
        }
    }

    public static function arDueSoon(AccountReceivable $ar, $daysUntilDue)
    {
        // Notify admin
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new PaymentDueNotification(
                $ar,
                "Payment for AR #{$ar->id} due in {$daysUntilDue} days"
            ));
        }

        // Notify customer
        if ($ar->customer->user) {
            $ar->customer->user->notify(new PaymentDueNotification(
                $ar,
                "Your payment of ₱{$ar->monthly_payment} is due in {$daysUntilDue} days"
            ));
        }
    }

    public static function lowInventory($product, $quantity)
    {
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new LowInventoryNotification(
                $product,
                "Product {$product->name} is running low ({$quantity} remaining)"
            ));
        }
    }

    // Customer notifications
    public static function preorderDisapproved(Preorder $preorder, $reason)
    {
        CustomerNotification::create([
            'customer_id' => $preorder->customer_id,
            'title' => 'Pre-order Disapproved',
            'message' => "Your pre-order #{$preorder->id} has been disapproved. Reason: {$reason}",
            'type' => 'preorder_disapproval'
        ]);
    }

    public static function preorderApproved(Preorder $preorder)
    {
        // Get the product names from the preorder items
        $productNames = $preorder->preorderItems->map(function($item) {
            return $item->product->product_name;
        })->implode(', ');

        CustomerNotification::create([
            'customer_id' => $preorder->customer_id,
            'title' => 'Pre-order Approved',
            'message' => "Your pre-order for {$productNames} has been approved!",
            'type' => 'preorder_approval'
        ]);
    }

    public static function paymentApproved($submission)
    {
        CustomerNotification::create([
            'customer_id' => $submission->customer_id,
            'title' => 'Payment Approved',
            'message' => "Your payment of ₱" . number_format($submission->amount, 2) . " has been approved.",
            'type' => 'payment_approved'
        ]);
    }

    public static function paymentRejected($submission)
    {
        CustomerNotification::create([
            'customer_id' => $submission->customer_id,
            'title' => 'Payment Rejected',
            'message' => "Your payment of ₱" . number_format($submission->amount, 2) . " has been rejected. Reason: {$submission->rejection_reason}",
            'type' => 'payment_rejected'
        ]);
    }

    public static function loanActivated($preorder)
    {
        CustomerNotification::create([
            'customer_id' => $preorder->customer_id,
            'title' => 'Loan Activated',
            'message' => "Your loan for {$preorder->preorderItems->first()->product->product_name} is now active. Your monthly payment of ₱" . number_format($preorder->monthly_payment, 2) . " will be due every " . now()->format('jS') . " of the month.",
            'type' => 'loan_activated'
        ]);
    }

    public static function orderCancelledByCustomer(Preorder $preorder, $reason)
    {
        // Notify admin
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new PreorderStatusNotification(
                $preorder,
                'Order Cancelled by Customer',
                "Order #{$preorder->id} has been cancelled by {$preorder->customer->name}. Reason: {$reason}"
            ));
        }

        // Create customer notification
        
    }
}