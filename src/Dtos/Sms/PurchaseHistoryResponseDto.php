<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class PurchaseHistoryResponseDto {
    public function __construct(
        public bool               $success,
        public ?array             $purchases = null,
        public ?OrangeApiErrorDto $error = null
    ) {
    }

    public static function fromSuccess(array $data): self {
        $purchases = array_map(
            static fn($purchase) => PurchaseHistoryDto::fromArray($purchase),
            $data
        );

        return new self(
            success: true,
            purchases: $purchases
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
