<?php

namespace tanyudii\YinCore;

use Illuminate\Support\ServiceProvider;
use tanyudii\YinCore\Services\YinRequestService;
use tanyudii\YinCore\Services\YinResourceService;

class YinCoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("yin-resource-service", function () {
            return new YinResourceService;
        });

        $this->app->bind("yin-request-service", function () {
            return new YinRequestService;
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
