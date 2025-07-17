<?php

namespace Tmoh\OrangeSmsPackage\Facades;

use Tmoh\OrangeSmsPackage\Contracts\OrangeSmsServiceInterface;
use Tmoh\OrangeSmsPackage\Dtos\Sms\OAuthTokenDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\PurchaseHistoryResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SendSmsResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsBalanceResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsUsageResponseDto;
use Illuminate\Support\Facades\Facade;

/**
 * @method static OAuthTokenDto authenticate()
 * @method static SendSmsResponseDto sendSms(string $recipientAddress, string $message, ?string $senderName = null)
 * @method static SmsBalanceResponseDto viewSmsBalance()
 * @method static SmsUsageResponseDto viewSmsUsage()
 * @method static PurchaseHistoryResponseDto viewPurchaseHistory()
 */
class OrangeSms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return OrangeSmsServiceInterface::class;
    }
}
