<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $showNotifications = false;
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            $this->notifications = auth()->user()
                ->notifications()
                ->latest()
                ->take(10)
                ->get();

            $this->unreadCount = auth()->user()
                ->unreadNotifications()
                ->count();
        }
    }

    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function viewPayment($paymentId)
    {
        try {
            if (!$paymentId) {
                session()->flash('error', 'Invalid payment submission ID.');
                return;
            }

            // First verify the payment submission exists
            $paymentSubmission = \App\Models\PaymentSubmission::find($paymentId);
            
            if (!$paymentSubmission) {
                session()->flash('error', 'Payment submission not found.');
                return;
            }
            
            // Store in session before redirect
            session(['pending_payment_submission' => $paymentId]);
            
            // Use Livewire's navigation method
            return $this->redirect('/payments');
            
        } catch (\Exception $e) {
            \Log::error('Payment view error:', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Unable to load payment submission.');
        }
    }

    public function viewPreorder($preorderId)
    {
        return redirect()->route('preorders.index', ['preorder_id' => $preorderId]);
    }

    public function render()
    {
        return view('livewire.admin.notification-bell');
    }
}