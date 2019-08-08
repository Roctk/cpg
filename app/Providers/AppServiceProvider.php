<?php

namespace App\Providers;

use App\Services\Notifications\DeviceNotificationsSender;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DeviceNotificationsSender::class, function ($app) {
            $config = $app->get('config');
            return new DeviceNotificationsSender($config->get('app.firebase_api_key'), $config->get('app.firebase_topic'));
        });
    }
}
