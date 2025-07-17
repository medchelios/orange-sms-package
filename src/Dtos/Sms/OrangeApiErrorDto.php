<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class OrangeApiErrorDto {
    public function __construct(
        public int    $code,
        public string $message,
        public string $description
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            code: $data['code'],
            message: $data['message'],
            description: $data['description']
        );
    }

    public function toArray(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'description' => $this->description
        ];
    }
}
