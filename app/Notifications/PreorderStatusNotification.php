<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Preorder;

class PreorderStatusNotification extends Notification
{
    use Queueable;

    protected $preorder;
    protected $title;
    protected $message;

    public function __construct(Preorder $preorder, $title, $message)
    {
        $this->preorder = $preorder;
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'preorder_submission_id' => $this->preorder->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => 'preorder_status_change'
        ];
    }
} 