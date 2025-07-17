<?php

namespace Tmoh\OrangeSmsPackage\Contracts;

use Tmoh\OrangeSmsPackage\Dtos\Sms\OAuthTokenDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\PurchaseHistoryResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SendSmsResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsBalanceResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsUsageResponseDto;

interface OrangeSmsServiceInterface {
    public function authenticate(): OAuthTokenDto;
    public function sendSms(string $recipientAddress, string $message, ?string $senderName = null): SendSmsResponseDto;
    public function viewSmsBalance(): SmsBalanceResponseDto;
    public function viewSmsUsage(): SmsUsageResponseDto;
    public function viewPurchaseHistory(): PurchaseHistoryResponseDto;
}
