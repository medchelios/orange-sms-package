<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsUsageResponseDto {
    public function __construct(
        public bool               $success,
        public ?SmsUsageDto       $partnerStatistics = null,
        public ?OrangeApiErrorDto $error = null
    ) {
    }

    public static function fromSuccess(array $data): self {
        $partnerStatistics = SmsUsageDto::fromArray($data['partnerStatistics']);

        return new self(
            success: true,
            partnerStatistics: $partnerStatistics
        );
    }

    public static function fromError(array $errorData): self {
        return new self(
            success: false,
            error: OrangeApiErrorDto::fromArray($errorData)
        );
    }

    public static function fromException(string $message): self {
        $error = new OrangeApiErrorDto(
            code: 500,
            message: 'Internal Error',
            description: $message
        );

        return new self(
            success: false,
            error: $error
        );
    }
}
