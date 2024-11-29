<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentDueReminder extends Notification
{
    use Queueable;

    protected $ar;
    protected $dueDate;

    public function __construct($ar, $dueDate)
    {
        $this->ar = $ar;
        $this->dueDate = $dueDate;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Payment Due Reminder',
            'message' => "Your monthly payment of ₱" . number_format($this->ar->monthly_payment, 2) . " is due on " . $this->dueDate->format('M d, Y'),
            'type' => 'payment_reminder',
            'amount' => $this->ar->monthly_payment,
            'due_date' => $this->dueDate
        ];
    }
} 