<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\CustomerNotification;

class CustomerNotifications extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function render()
    {
        $notifications = collect([]);
        
        if (auth()->check() && auth()->user()->customer) {
            $notifications = CustomerNotification::where('customer_id', auth()->user()->customer->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('livewire.ecommerce.customer-notifications', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($notificationId)
    {
        if (auth()->check() && auth()->user()->customer) {
            $notification = CustomerNotification::where('customer_id', auth()->user()->customer->id)
                ->where('id', $notificationId)
                ->first();
                
            if ($notification) {
                $notification->update(['is_read' => true]);
                $this->updateUnreadCount();
                $this->dispatch('notification-updated');
            }
        }
    }

    public function markAllAsRead()
    {
        if (auth()->check() && auth()->user()->customer) {
            CustomerNotification::where('customer_id', auth()->user()->customer->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            $this->updateUnreadCount();
            $this->dispatch('notification-updated');
        }
    }

    private function updateUnreadCount()
    {
        if (auth()->check() && auth()->user()->customer) {
            $this->unreadCount = CustomerNotification::where('customer_id', auth()->user()->customer->id)
                ->where('is_read', false)
                ->count();
        }
    }
}