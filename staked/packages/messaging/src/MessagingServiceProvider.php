<?php
// src/MessagingServiceProvider.php
namespace YourName\Messaging;

use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'messaging');

        // load migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // publish assets (optional)
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/messaging'),
        ], 'messaging-views');
    }

    public function register()
    {
        //
    }
}
