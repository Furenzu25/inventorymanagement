<?php

namespace App\Livewire\Messages;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatBox extends Component
{
    public $message = '';
    public $selectedUser = null;
    public $messages = [];
    public $users = [];

    public function mount()
    {
        $this->loadUsers();
        $this->pollMessages();
    }

    public function pollMessages()
    {
        if ($this->selectedUser) {
            $this->loadMessages();
        }
    }

    public function getListeners()
    {
        return [
            'echo-private:messages.'.auth()->id().',MessageSent' => 'pollMessages',
            'refresh-messages' => '$refresh'
        ];
    }

    public function loadUsers()
    {
        if (Auth::user()->is_admin) {
            $this->users = User::whereHas('customer')
                ->select('id', 'name', 'email')
                ->get()
                ->toArray();
        } else {
            $this->users = User::where('is_admin', true)
                ->select('id', 'name', 'email')
                ->get()
                ->toArray();
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = (int) $userId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) return;

        $this->messages = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $this->selectedUser);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->selectedUser)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray();

        // Mark received messages as read
        Message::where('sender_id', $this->selectedUser)
              ->where('receiver_id', Auth::id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|min:1',
            'selectedUser' => 'required'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser,
            'content' => $this->message,
        ]);

        event(new MessageSent($message));

        $this->message = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.messages.chat-box');
    }
} 