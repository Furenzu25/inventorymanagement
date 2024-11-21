<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PaymentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Payment Approved',
            'message' => "Your payment of ₱{$this->submission->amount} has been approved.",
            'type' => 'payment_approved'
        ];
    }
} 