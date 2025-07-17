<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsExceptionDto {
    public function __construct(
        public string $messageId,
        public string $text,
        public ?array $variables = null
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            messageId: $data['messageId'],
            text: $data['text'],
            variables: $data['variables'] ?? null
        );
    }

    public function toArray(): array {
        $result = [
            'messageId' => $this->messageId,
            'text' => $this->text
        ];

        if ($this->variables !== null) {
            $result['variables'] = $this->variables;
        }

        return $result;
    }
}
