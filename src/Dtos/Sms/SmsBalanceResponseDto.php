<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsBalanceResponseDto {
    public function __construct(
        public bool               $success,
        public ?array             $balances = null,
        public ?OrangeApiErrorDto $error = null
    ) {
    }

    public static function fromSuccess(array $data): self {
        $balances = array_map(
            static fn($balance) => SmsBalanceDto::fromArray($balance),
            $data
        );

        return new self(
            success: true,
            balances: $balances
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
