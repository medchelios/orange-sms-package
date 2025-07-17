<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SmsSuccessResponseDto
{
	public function __construct(
		public array  $address,
		public string $senderAddress,
		public string $message,
		public string $resourceURL,
		public ?string $senderName = null
	) {}

	public static function fromArray(array $data): self
	{
		return new self(
			address: $data['address'],
			senderAddress: $data['senderAddress'],
			message: $data['outboundSMSTextMessage']['message'],
			resourceURL: $data['resourceURL'],
			senderName: $data['senderName'] ?? null
		);
	}

	public function toArray(): array
	{
		$data = [
			'address' => $this->address,
			'senderAddress' => $this->senderAddress,
			'outboundSMSTextMessage' => [
				'message' => $this->message
			],
			'resourceURL' => $this->resourceURL
		];

		if ($this->senderName !== null) {
			$data['senderName'] = $this->senderName;
		}

		return $data;
	}
}