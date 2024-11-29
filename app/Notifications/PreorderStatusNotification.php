<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PreorderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $preorder;
    protected $title;
    protected $message;

    public function __construct($preorder, $title, $message)
    {
        $this->preorder = $preorder;
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => 'preorder_status',
            'preorder_id' => $this->preorder->id,
            'total_amount' => $this->preorder->total_amount,
            'created_at' => now()
        ];
    }
} 