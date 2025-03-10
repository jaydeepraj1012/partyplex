<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The message instance.
     */
    public $message;

    /**
     * The sender instance.
     */
    public $sender;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, User $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'attachment' => $this->message->attachment,
            'attachment_url' => $this->message->attachment ? asset('storage/' . $this->message->attachment) : null,
            'booking_id' => $this->message->booking_id,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at->format('M d, g:i A'),
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'profile_image' => $this->sender->profile_image ? asset('storage/' . $this->sender->profile_image) : null,
            ],
        ];
    }
}
