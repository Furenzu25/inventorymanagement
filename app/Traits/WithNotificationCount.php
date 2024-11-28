<?php

namespace App\Traits;

use App\Models\CustomerNotification;

trait WithNotificationCount
{
    public function getUnreadCountProperty()
    {
        if (!auth()->check() || !auth()->user()->customer) {
            return 0;
        }
        
        return CustomerNotification::where('customer_id', auth()->user()->customer->id)
            ->where('is_read', false)
            ->count();
    }
} 