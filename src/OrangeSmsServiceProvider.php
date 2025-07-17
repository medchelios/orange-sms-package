<?php

namespace Tmoh\OrangeSmsPackage;

use Illuminate\Support\ServiceProvider;
use Tmoh\OrangeSmsPackage\Contracts\OrangeSmsServiceInterface;
use Tmoh\OrangeSmsPackage\Services\OrangeSmsApiService;

class OrangeSmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/orange_sms.php', 'orange_sms'
        );

        $this->app->bind(OrangeSmsServiceInterface::class, OrangeSmsApiService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/orange_sms.php' => config_path('orange_sms.php'),
            ], 'orange-sms-config');
        }
    }
} 