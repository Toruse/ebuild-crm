<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User\User;

class UserMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $fields;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $fields)
    {
        $this->user = $user;
        $this->fields = $fields;
    }
}
