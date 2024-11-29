<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\InventoryItem;

class StockInCompleted extends Notification
{
    private $inventoryItem;

    public function __construct(InventoryItem $inventoryItem)
    {
        $this->inventoryItem = $inventoryItem;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Stock-in Completed',
            'message' => "Product {$this->inventoryItem->product->name} has been stocked in with verification code: {$this->inventoryItem->pickup_verification}",
            'inventory_item_id' => $this->inventoryItem->id
        ];
    }
}