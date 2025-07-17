<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsDeliveryReceiptDto {
    public function __construct(
        public string $notifyURL,
        public string $resourceURL
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            notifyURL: $data['callbackReference']['notifyURL'],
            resourceURL: $data['resourceURL']
        );
    }

    public function toArray(): array {
        return [
            'callbackReference' => [
                'notifyURL' => $this->notifyURL
            ],
            'resourceURL' => $this->resourceURL
        ];
    }
}
