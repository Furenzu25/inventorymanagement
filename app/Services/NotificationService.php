<?php

namespace App\Services;

use App\Models\Preorder;
use App\Models\AccountReceivable;
use App\Models\User;
use App\Notifications\PreorderStatusNotification;
use App\Notifications\PaymentDueNotification;
use App\Notifications\LowInventoryNotification;

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
        if ($preorder->customer->user) {
            $preorder->customer->user->notify(new PreorderStatusNotification(
                $preorder,
                'Pre-order Disapproved',
                "Your pre-order #{$preorder->id} has been disapproved. Reason: {$reason}"
            ));
        }
    }

    public static function preorderApproved(Preorder $preorder)
    {
        if ($preorder->customer->user) {
            $preorder->customer->user->notify(new PreorderStatusNotification(
                $preorder,
                'Pre-order Approved',
                "Your pre-order #{$preorder->id} has been approved!"
            ));
        }
    }
}