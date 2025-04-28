<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;



class GenreUpdated implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $genres;
    public $action;

    public function __construct($genres, $action)
    {
        $this->genres = $genres;
        $this->action = $action;
        Log::info('GenreUpdated event initialized', [
            'genres_id' => $genres->genres_id ?? null,
            'action' => $action
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('genres-channel');
    }

    public function broadcastAs()
    {
        return 'genres-updated';
    }
    public function broadcastWith()
    {
        $data = [
            'genres_id' => $this->genres->genres_id,
            'name' => $this->genres->name,
            'description' => $this->genres->description,
            'action' => $this->action
        ];
        Log::info('Broadcasting GenreUpdated event', $data);
        return $data;
    }
}
