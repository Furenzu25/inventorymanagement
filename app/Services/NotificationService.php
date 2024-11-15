<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Preorder;
use App\Models\AccountReceivable;

class NotificationService
{
    public static function preorderCreated(Preorder $preorder)
    {
        Notification::create([
            'type' => 'preorder_created',
            'title' => 'New Preorder',
            'message' => "New preorder #{$preorder->id} created by {$preorder->customer->name}",
            'data' => [
                'preorder_id' => $preorder->id,
                'customer_name' => $preorder->customer->name,
                'amount' => $preorder->total_amount
            ]
        ]);
    }

    public static function arDueSoon(AccountReceivable $ar, $daysUntilDue)
    {
        Notification::create([
            'type' => 'ar_due_soon',
            'title' => 'Payment Due Soon',
            'message' => "Payment for AR #{$ar->id} due in {$daysUntilDue} days",
            'data' => [
                'ar_id' => $ar->id,
                'customer_name' => $ar->customer->name,
                'due_amount' => $ar->monthly_payment
            ]
        ]);
    }

    public static function lowInventory($product, $quantity)
    {
        Notification::create([
            'type' => 'low_inventory',
            'title' => 'Low Inventory Alert',
            'message' => "Product {$product->name} is running low ({$quantity} remaining)",
            'data' => [
                'product_id' => $product->id,
                'current_quantity' => $quantity
            ]
        ]);
    }
}