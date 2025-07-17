<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class OAuthTokenDto {
    public function __construct(
        public ?string $tokenType = null,
        public ?string $accessToken = null,
        public ?int    $expiresIn = null,
        public ?string $error = null,
        public ?string $errorDescription = null,
        public bool    $success = false
    ) {
    }

    public static function fromSuccess(array $data): self {
        return new self(
            tokenType: $data['token_type'] ?? null,
            accessToken: $data['access_token'] ?? null,
            expiresIn: $data['expires_in'] ?? null,
            success: true
        );
    }

    public static function fromError(string $error, string $errorDescription): self {
        return new self(
            error: $error,
            errorDescription: $errorDescription,
            success: false
        );
    }

    public function toArray(): array {
        if ($this->success) {
            return [
                'token_type' => $this->tokenType,
                'access_token' => $this->accessToken,
                'expires_in' => $this->expiresIn
            ];
        }

        return [
            'error' => $this->error,
            'error_description' => $this->errorDescription
        ];
    }
}
