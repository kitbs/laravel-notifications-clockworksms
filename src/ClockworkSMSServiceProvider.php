<?php

namespace NotificationChannels\ClockworkSMS;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\ClockworkSMS\ClockworkSMSClientInterface;

class ClockworkSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ClockworkSMSChannel::class)
        ->needs(ClockworkSMSClientInterface::class)
        ->give(function () {
            $config = config('services.clockworksms');

            return new ClockworkSMSClient(
                array_get($config, 'key'),
                array_get($config, 'truncate'),
                array_get($config, 'invalid_char_action')
                array_get($config, 'from')
            );
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
