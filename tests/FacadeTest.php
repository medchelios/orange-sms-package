<?php

namespace Tmoh\OrangeSmsPackage\Tests;

use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsSuccessResponseDto;
use Tmoh\OrangeSmsPackage\Facades\OrangeSms;
use Tmoh\OrangeSmsPackage\Contracts\OrangeSmsServiceInterface;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SendSmsResponseDto;
use Tmoh\OrangeSmsPackage\Services\OrangeSmsApiService;

class FacadeTest extends TestCase
{
    public function test_facade_can_be_resolved()
    {
        $this->assertInstanceOf(
            OrangeSmsApiService::class,
            OrangeSms::getFacadeRoot()
        );
    }

    public function test_send_sms_via_facade_returns_expected_dto()
    {
        $smsSuccess = new SmsSuccessResponseDto(
            address: ['+224624000000'],
            senderAddress: '+224624000000',
            message: 'Hello',
            resourceURL: 'https://api.orange.com/sms/12345',
            senderName: 'MyApp'
        );

        $mock = $this->createMock(OrangeSmsServiceInterface::class);
        $mock->method('sendSms')
            ->with('+224624000000', 'Hello', 'MyApp')
            ->willReturn(new SendSmsResponseDto(
                success: true,
                smsResponse: $smsSuccess
            ));

        $this->app->instance(OrangeSmsServiceInterface::class, $mock);

        $response = OrangeSms::sendSms('+224624000000', 'Hello', 'MyApp');

        $this->assertInstanceOf(SendSmsResponseDto::class, $response);
        $this->assertTrue($response->success);
        $this->assertInstanceOf(SmsSuccessResponseDto::class, $response->smsResponse);
        $this->assertEquals('Hello', $response->smsResponse->message);
        $this->assertEquals('MyApp', $response->smsResponse->senderName);
        $this->assertEquals(['+224624000000'], $response->smsResponse->address);
        $this->assertEquals('https://api.orange.com/sms/12345', $response->smsResponse->resourceURL);
    }
} 