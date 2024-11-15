<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Notification;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showNotifications = false;
    
    protected $listeners = ['refreshNotifications' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->unreadCount = Notification::where('status', 'unread')->count();
        $this->notifications = Notification::latest()->take(5)->get();
    }

    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
    }

    public function markAsRead($id)
    {
        Notification::find($id)->update(['status' => 'read']);
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin.notification-bell');
    }
}