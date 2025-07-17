<?php

namespace Tmoh\OrangeSmsPackage\Services;

use Tmoh\OrangeSmsPackage\Contracts\OrangeSmsServiceInterface;
use Tmoh\OrangeSmsPackage\Dtos\Sms\OAuthTokenDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\PurchaseHistoryResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SendSmsResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsBalanceResponseDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsMessageDto;
use Tmoh\OrangeSmsPackage\Dtos\Sms\SmsUsageResponseDto;
use Tmoh\OrangeSmsPackage\Helpers\OrangeSmsRequestHelper;
use Exception;

class OrangeSmsApiService implements OrangeSmsServiceInterface
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('orange_sms');
    }

    public function authenticate(): OAuthTokenDto
    {
        try {
            $tokenUrl = $this->config['base_url'] . '/oauth/v3/token';
            $result = OrangeSmsRequestHelper::postToken($tokenUrl);

            if ($result['success']) {
                return OAuthTokenDto::fromSuccess($result['data']);
            }

            $error = $result['error'] ?? 'unknown_error';
            $errorDescription = $result['error_description'] ?? 'Une erreur inconnue est survenue';

            return OAuthTokenDto::fromError($error, $errorDescription);
        } catch (Exception $e) {
            return OAuthTokenDto::fromError(
                'connection_error',
                'Erreur de connexion OAuth: ' . $e->getMessage()
            );
        }
    }

    public function viewSmsBalance(): SmsBalanceResponseDto
    {
        try {
            $authResult = $this->authenticate();
            if (!$authResult->success) {
                return SmsBalanceResponseDto::fromError([
                    'code' => 401,
                    'message' => $authResult->error ?? 'Authentication failed',
                    'description' => $authResult->errorDescription ?? 'Unable to authenticate'
                ]);
            }

            $accessToken = $authResult->accessToken;
            $url = $this->config['base_url'] . '/sms/admin/v1/contracts';
            $result = OrangeSmsRequestHelper::getWithAuth($url, [], $accessToken);

            if (!$result['success']) {
                $errorData = isset($result['error']) && is_array($result['error'])
                    ? $result['error']
                    : [
                        'code' => 500,
                        'message' => 'API Error',
                        'description' => $result['message'] ?? 'Unknown error occurred'
                    ];

                return SmsBalanceResponseDto::fromError($errorData);
            }

            return SmsBalanceResponseDto::fromSuccess($result['data']);
        } catch (Exception $e) {
            return SmsBalanceResponseDto::fromException(
                'Erreur lors de la récupération du solde SMS: ' . $e->getMessage()
            );
        }
    }

    public function viewSmsUsage(): SmsUsageResponseDto
    {
        try {
            $authResult = $this->authenticate();
            if (!$authResult->success) {
                return SmsUsageResponseDto::fromError([
                    'code' => 401,
                    'message' => $authResult->error ?? 'Authentication failed',
                    'description' => $authResult->errorDescription ?? 'Unable to authenticate'
                ]);
            }

            $accessToken = $authResult->accessToken;
            $url = $this->config['base_url'] . '/sms/admin/v1/statistics';
            $result = OrangeSmsRequestHelper::getWithAuth($url, [], $accessToken);

            if (!$result['success']) {
                $errorData = isset($result['error']) && is_array($result['error'])
                    ? $result['error']
                    : [
                        'code' => 500,
                        'message' => 'API Error',
                        'description' => $result['message'] ?? 'Unknown error occurred'
                    ];

                return SmsUsageResponseDto::fromError($errorData);
            }

            return SmsUsageResponseDto::fromSuccess($result['data']);
        } catch (Exception $e) {
            return SmsUsageResponseDto::fromException(
                'Erreur lors de la récupération des statistiques SMS: ' . $e->getMessage()
            );
        }
    }

    public function viewPurchaseHistory(): PurchaseHistoryResponseDto
    {
        try {
            $authResult = $this->authenticate();
            if (!$authResult->success) {
                return PurchaseHistoryResponseDto::fromError([
                    'code' => 401,
                    'message' => $authResult->error ?? 'Authentication failed',
                    'description' => $authResult->errorDescription ?? 'Unable to authenticate'
                ]);
            }

            $accessToken = $authResult->accessToken;
            $url = $this->config['base_url'] . '/sms/admin/v1/purchaseorders';

            $result = OrangeSmsRequestHelper::getWithAuth($url, [], $accessToken);

            if (!$result['success']) {
                $errorData = isset($result['error']) && is_array($result['error'])
                    ? $result['error']
                    : [
                        'code' => 500,
                        'message' => 'API Error',
                        'description' => $result['message'] ?? 'Unknown error occurred'
                    ];

                return PurchaseHistoryResponseDto::fromError($errorData);
            }

            return PurchaseHistoryResponseDto::fromSuccess($result['data']);
        } catch (Exception $e) {
            return PurchaseHistoryResponseDto::fromException(
                'Erreur lors de la récupération de l\'historique des achats SMS: ' . $e->getMessage()
            );
        }
    }

    public function sendSms(string $recipientAddress, string $message, ?string $senderName = null): SendSmsResponseDto
    {
        try {
            $authResult = $this->authenticate();
            if (!$authResult->success) {
                return SendSmsResponseDto::fromException(
                    'Authentication failed: ' . ($authResult->errorDescription ?? 'Unable to authenticate')
                );
            }

            $accessToken = $authResult->accessToken;

            $senderAddress = $this->config['default_sender_address'];
            $formattedSender = $this->formatPhoneNumber($senderAddress);
            $formattedRecipient = $this->formatPhoneNumber($recipientAddress);

            // Formater le sender name selon les contraintes Orange SMS
            $finalSenderName = $this->formatSenderName($senderName ?? $this->config['default_sender_name']);

            $url = $this->config['base_url'] . '/smsmessaging/v1/outbound/' . urlencode($formattedSender) . '/requests';

            $smsMessage = new SmsMessageDto(
                address: $formattedRecipient,
                senderAddress: $formattedSender,
                message: $message,
                senderName: $finalSenderName
            );

            $result = OrangeSmsRequestHelper::postWithAuth($url, $smsMessage->toArray(), $accessToken);

            if (!$result['success']) {
                $errorData = $result['error'] ?? [
                    'requestError' => [
                        'serviceException' => [
                            'messageId' => 'SVC0001',
                            'text' => 'A service error occurred',
                            'variables' => [$result['message'] ?? 'Unknown error']
                        ]
                    ]
                ];

                return SendSmsResponseDto::fromError($errorData);
            }

            return SendSmsResponseDto::fromSuccess($result['data']);
        } catch (Exception $e) {
            return SendSmsResponseDto::fromException(
                'Erreur lors de l\'envoi du SMS: ' . $e->getMessage()
            );
        }
    }

    private function formatPhoneNumber(string $phoneNumber): string
    {
        if (str_starts_with($phoneNumber, 'tel:')) {
            return $phoneNumber;
        }

        if (str_starts_with($phoneNumber, '+')) {
            return 'tel:' . $phoneNumber;
        }

        return 'tel:+' . $phoneNumber;
    }

    /**
     * Formater le sender name selon les contraintes Orange SMS
     * Limité à 11 caractères alphanumériques ou espaces
     */
    private function formatSenderName(string $senderName): string
    {
        $formatted = preg_replace('/[^a-zA-Z0-9\s]/', '', $senderName);
        $formatted = substr($formatted, 0, 11);
        $formatted = trim($formatted);
        if (empty($formatted)) {
            $formatted = 'SMS 987519';
        }

        return $formatted;
    }
}
