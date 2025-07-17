<?php

namespace Tmoh\OrangeSmsPackage\Dtos\Sms;

readonly class SendSmsResponseDto
{
	public function __construct(
		public bool                   $success,
		public ?SmsSuccessResponseDto $smsResponse = null,
		public ?SmsErrorDto           $error = null
	) {}

	public static function fromSuccess(array $data): self
	{
		$smsResponse = SmsSuccessResponseDto::fromArray($data['outboundSMSMessageRequest']);

		return new self(
			success: true,
			smsResponse: $smsResponse
		);
	}

	public static function fromError(array $errorData): self
	{
		$error = SmsErrorDto::fromArray($errorData['requestError']);

		return new self(
			success: false,
			error: $error
		);
	}

	public static function fromException(string $message): self
	{
		$serviceException = new SmsExceptionDto(
			messageId: 'SVC1000',
			text: 'Internal Error',
			variables: [$message]
		);

		$error = new SmsErrorDto(serviceException: $serviceException);

		return new self(
			success: false,
			error: $error
		);
	}
}

