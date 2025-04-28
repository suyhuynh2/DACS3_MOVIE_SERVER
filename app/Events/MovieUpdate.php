<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class MovieUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $movie;
    public $action;

    public function __construct($movie, $action)
    {
        $this->movie = $movie;
        $this->action = $action;
        Log::info('MovieUpdate event initialized', [
            'movie_id' => $movie->id ?? null,
            'action' => $action
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('movies-channel');
    }

    public function broadcastAs()
    {
        return 'movies-updated';
    }

    public function broadcastWith()
    {
        $data = $this->movie->toArray();
        $data['action'] = $this->action;
        Log::info('Broadcasting MovieUpdate event', $data);
        return $data;
    }
}
