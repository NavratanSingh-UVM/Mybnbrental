<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
     public $message;
     public $senderId;
     public $reciverId;
    public $channel;
    public $event;
    /**
     * Create a new event instance.
     */
    public function __construct($data,$channel,$event)
    {
       // dd($data);
        $this->message =$data['message'];
        $this->$channel =$channel;
        $this->$event =$event;
        $this->senderId = $data['auth_id'];
        $this->reciverId = $data['reciverId'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {   
        return new Channel('Chat',$this->message, $this->senderId,$this->reciverId);
    }
    public function broadcastAs()
  {
      return 'NewMessage';
  }
}
