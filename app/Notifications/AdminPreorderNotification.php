<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Preorder;

class AdminPreorderNotification extends Notification
{
    use Queueable;

    private $preorder;

    public function __construct(Preorder $preorder)
    {
        $this->preorder = $preorder;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Preorder Submission',
            'message' => "New preorder of ₱{$this->preorder->total_amount} submitted for review",
            'preorder_submission_id' => $this->preorder->id
        ];
    }
} 