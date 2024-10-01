<?php declare(strict_types = 1);

namespace QaData\Psr7;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use QaData\Psr7\Extra\ExtraResponseTrait;

class Psr7Response extends Response
{

	use ExtraResponseTrait;

	public static function of(ResponseInterface $response): ResponseInterface
	{
		return new self(
			$response->getStatusCode(),
			$response->getHeaders(),
			$response->getBody(),
			$response->getProtocolVersion(),
			$response->getReasonPhrase(),
		);
	}

	public static function fromGlobals(): ResponseInterface
	{
		return new self();
	}

}
