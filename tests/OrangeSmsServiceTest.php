<?php

namespace Tmoh\OrangeSmsPackage\Tests;

use Tmoh\OrangeSmsPackage\Services\OrangeSmsApiService;

class OrangeSmsServiceTest extends TestCase
{
    public function test_service_can_be_instantiated()
    {
        $service = new OrangeSmsApiService();
        
        $this->assertInstanceOf(OrangeSmsApiService::class, $service);
    }

    public function test_config_is_loaded()
    {
        $service = new OrangeSmsApiService();
        
        // Utiliser la réflexion pour accéder à la propriété config
        $reflection = new \ReflectionClass($service);
        $configProperty = $reflection->getProperty('config');
        $configProperty->setAccessible(true);
        $config = $configProperty->getValue($service);
        
        $this->assertIsArray($config);
        $this->assertArrayHasKey('base_url', $config);
        $this->assertArrayHasKey('basic_token', $config);
    }
} 