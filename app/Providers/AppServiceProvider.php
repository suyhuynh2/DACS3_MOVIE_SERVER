<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\History;
use App\Observers\HistoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        History::observe(HistoryObserver::class);
    }
}
