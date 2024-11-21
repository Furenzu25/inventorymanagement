<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PaymentSubmission;

class NewPaymentSubmission extends Notification
{
    use Queueable;

    private $paymentSubmission;

    public function __construct(PaymentSubmission $paymentSubmission)
    {
        $this->paymentSubmission = $paymentSubmission;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Payment Submission',
            'message' => "New payment of ₱{$this->paymentSubmission->amount} submitted for review",
            'payment_submission_id' => $this->paymentSubmission->id
        ];
    }
}