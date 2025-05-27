<?php

namespace App\Observers;

use App\Models\History;
use App\Models\Movie;

class HistoryObserver
{
    /**
     * Handle the History "created" event.
     */
    public function created(History $history)
    {
        // Khi một lượt xem mới được ghi lại, tăng views
        Movie::where('movie_id', $history->movie_id)->increment('views');
    }

    /**
     * Handle the History "updated" event.
     */
    public function updated(History $history): void
    {
        //
    }

    /**
     * Handle the History "deleted" event.
     */
    public function deleted(History $history): void
    {
        //
    }

    /**
     * Handle the History "restored" event.
     */
    public function restored(History $history): void
    {
        //
    }

    /**
     * Handle the History "force deleted" event.
     */
    public function forceDeleted(History $history): void
    {
        //
    }
}
