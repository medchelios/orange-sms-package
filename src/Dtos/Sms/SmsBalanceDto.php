<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsBalanceDto {
    public function __construct(
        public string $id,
        public string $type,
        public string $developerId,
        public string $applicationId,
        public string $country,
        public string $offerName,
        public int    $availableUnits,
        public int    $requestedUnits,
        public string $status,
        public string $expirationDate,
        public string $creationDate,
        public string $lastUpdateDate
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            id: $data['id'],
            type: $data['type'],
            developerId: $data['developerId'],
            applicationId: $data['applicationId'],
            country: $data['country'],
            offerName: $data['offerName'],
            availableUnits: $data['availableUnits'],
            requestedUnits: $data['requestedUnits'],
            status: $data['status'],
            expirationDate: $data['expirationDate'],
            creationDate: $data['creationDate'],
            lastUpdateDate: $data['lastUpdateDate']
        );
    }
}
