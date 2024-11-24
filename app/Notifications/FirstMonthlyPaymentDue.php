<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\AccountReceivable;

class FirstMonthlyPaymentDue extends Notification
{
    use Queueable;

    private $accountReceivable;

    public function __construct(AccountReceivable $accountReceivable)
    {
        $this->accountReceivable = $accountReceivable;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $dueDate = $this->accountReceivable->loan_start_date->addMonth();
        
        return [
            'title' => 'First Monthly Payment Due',
            'message' => "Your first monthly payment of ₱{$this->accountReceivable->monthly_payment} is due on {$dueDate->format('M d, Y')}",
            'type' => 'payment_due',
            'amount' => $this->accountReceivable->monthly_payment,
            'due_date' => $dueDate
        ];
    }
} 