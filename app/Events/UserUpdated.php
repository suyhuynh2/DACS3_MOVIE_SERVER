<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class UserUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $action;

    public function __construct($user, $action)
    {
        $this->user = $user;
        $this->action = $action;

        Log::info('UserUpdated event initialized', [
            'user_id' => $user->firebase_uid ?? null,
            'action' => $action
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('user-channel-' . $this->user->firebase_uid);
    }

    public function broadcastAs()
    {
        return 'user-updated';
    }

    public function broadcastWith()
    {
        $data = $this->user->toArray();
        $data['action'] = $this->action;

        Log::info('Broadcasting UserUpdated event', $data);
        return $data;
    }
}
