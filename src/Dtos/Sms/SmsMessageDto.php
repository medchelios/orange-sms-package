<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsMessageDto {
    public function __construct(
        public string $address,
        public string $senderAddress,
        public string $message,
        public ?string $senderName = null
    ) {
    }

    public function toArray(): array {
        return [
            'outboundSMSMessageRequest' => [
                'address' => $this->address,
                'senderAddress' => $this->senderAddress,
                'senderName' => $this->senderName,
                'outboundSMSTextMessage' => [
                    'message' => $this->message
                ]
            ]
        ];
    }
}
