<?php

namespace App\Providers;
use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('telegram', function($app){
            
            return new TelegramService(new Http());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
