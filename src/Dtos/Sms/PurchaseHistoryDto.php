<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class PurchaseHistoryDto {
    public function __construct(
        public string  $id,
        public string  $developerId,
        public string  $contractId,
        public string  $country,
        public string  $offerName,
        public string  $bundleId,
        public string  $bundleDescription,
        public int     $price,
        public string  $currency,
        public string  $purchaseDate,
        public string  $paymentMode,
        public ?string $paymentProviderOrderId,
        public string  $payerId,
        public string  $type,
        public int     $oldAvailableUnits,
        public int     $newAvailableUnits,
        public string  $oldExpirationDate,
        public string  $newExpirationDate,
        public string  $externalId,
        public ?string $comment
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            id: $data['id'],
            developerId: $data['developerId'],
            contractId: $data['contractId'],
            country: $data['country'],
            offerName: $data['offerName'],
            bundleId: $data['bundleId'],
            bundleDescription: $data['bundleDescription'],
            price: $data['price'],
            currency: $data['currency'],
            purchaseDate: $data['purchaseDate'],
            paymentMode: $data['paymentMode'],
            paymentProviderOrderId: $data['paymentProviderOrderId'],
            payerId: $data['payerId'],
            type: $data['type'],
            oldAvailableUnits: $data['oldAvailableUnits'],
            newAvailableUnits: $data['newAvailableUnits'],
            oldExpirationDate: $data['oldExpirationDate'],
            newExpirationDate: $data['newExpirationDate'],
            externalId: $data['externalId'],
            comment: $data['comment']
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'developerId' => $this->developerId,
            'contractId' => $this->contractId,
            'country' => $this->country,
            'offerName' => $this->offerName,
            'bundleId' => $this->bundleId,
            'bundleDescription' => $this->bundleDescription,
            'price' => $this->price,
            'currency' => $this->currency,
            'purchaseDate' => $this->purchaseDate,
            'paymentMode' => $this->paymentMode,
            'paymentProviderOrderId' => $this->paymentProviderOrderId,
            'payerId' => $this->payerId,
            'type' => $this->type,
            'oldAvailableUnits' => $this->oldAvailableUnits,
            'newAvailableUnits' => $this->newAvailableUnits,
            'oldExpirationDate' => $this->oldExpirationDate,
            'newExpirationDate' => $this->newExpirationDate,
            'externalId' => $this->externalId,
            'comment' => $this->comment
        ];
    }
}
