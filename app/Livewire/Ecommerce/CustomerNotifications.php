<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Traits\WithNotificationCount;

class CustomerNotifications extends Component
{
    use WithNotificationCount;

    public function render()
    {
        $notifications = collect([]);
        
        if (auth()->check()) {
            $notifications = auth()->user()
                ->notifications()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('livewire.ecommerce.customer-notifications', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($notificationId)
    {
        if (auth()->check()) {
            $notification = auth()->user()
                ->notifications()
                ->find($notificationId);
                
            if ($notification) {
                $notification->markAsRead();
            }
            
            $this->dispatch('notification-updated');
        }
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()
                ->notifications()
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
                
            $this->dispatch('notification-updated');
        }
    }
}