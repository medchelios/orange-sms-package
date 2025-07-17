<?php

namespace Tmoh\OrangeSmsPackage\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tmoh\OrangeSmsPackage\OrangeSmsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            OrangeSmsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configuration de test
        $app['config']->set('orange_sms.base_url', 'https://api.test.orange.com');
        $app['config']->set('orange_sms.basic_token', 'test_token');
        $app['config']->set('orange_sms.default_sender_address', '+1234567890');
        $app['config']->set('orange_sms.default_sender_name', 'TEST');
    }
} 