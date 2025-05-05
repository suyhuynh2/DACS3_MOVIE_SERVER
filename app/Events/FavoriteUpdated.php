<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class FavoriteUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $favorite;
    public $action;

    public function __construct($favorite, $action)
    {
        $this->favorite = $favorite;
        $this->action = $action;

        Log::info('FavoriteUpdated event initialized', [
            'favorite_id' => $favorite->favorite_id ?? null,
            'movie_id' => $favorite->movie_id ?? null,
            'firebase_uid' => $favorite->firebase_uid ?? null,
            'action' => $action
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('favorites-channel');
    }

    public function broadcastAs()
    {
        return 'favorites-updated';
    }

    public function broadcastWith()
    {
        $data = $this->favorite->toArray();
        $data['action'] = $this->action;

        Log::info('Broadcasting FavoriteUpdated event', $data);

        return $data;
    }
}
