<?php

namespace App\Traits;

trait WithNotificationCount
{
    public function getUnreadCountProperty()
    {
        if (!auth()->check()) {
            return 0;
        }
        
        return auth()->user()
            ->unreadNotifications
            ->count();
    }
} 