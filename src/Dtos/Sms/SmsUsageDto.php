<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsUsageDto {
    public function __construct(
        public string $developerId,
        public array  $statistics
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            developerId: $data['developerId'],
            statistics: $data['statistics']
        );
    }

    public function toArray(): array {
        return [
            'developerId' => $this->developerId,
            'statistics' => $this->statistics
        ];
    }
}
