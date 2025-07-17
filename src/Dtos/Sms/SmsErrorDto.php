<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsErrorDto {
    public function __construct(
        public ?SmsExceptionDto $serviceException = null,
        public ?SmsExceptionDto $policyException = null
    ) {
    }

    public static function fromArray(array $data): self {
        $serviceException = null;
        $policyException = null;

        if (isset($data['serviceException'])) {
            $serviceException = SmsExceptionDto::fromArray($data['serviceException']);
        }

        if (isset($data['policyException'])) {
            $policyException = SmsExceptionDto::fromArray($data['policyException']);
        }

        return new self(
            serviceException: $serviceException,
            policyException: $policyException
        );
    }

    public function toArray(): array {
        $result = [];

        if ($this->serviceException) {
            $result['serviceException'] = $this->serviceException->toArray();
        }

        if ($this->policyException) {
            $result['policyException'] = $this->policyException->toArray();
        }

        return $result;
    }
}
