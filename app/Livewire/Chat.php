<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class Chat extends Component
{
    public $messages;
    public $newMessage;

    public function mount()
    {
        $this->messages = Message::with('user')->get()->toArray();
        
    }

    public function render()
    {
        return view('livewire.chat');
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required',
        ]);

        $authenticatedUserId = Auth::guard('admin')->id();

        Message::create([
            'content' => $this->newMessage,
            'user_id' => $authenticatedUserId,
        ]);

        $this->newMessage = '';
        $this->messages = Message::with('user')->get()->toArray();
    }
}

