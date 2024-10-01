<?php declare(strict_types = 1);

namespace QaData\Psr7;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use QaData\Psr7\Extra\ExtraRequestTrait;

class Psr7Request extends Request
{

	use ExtraRequestTrait;

	public static function of(RequestInterface $request): RequestInterface
	{
		$new = new self(
			$request->getMethod(),
			$request->getUri(),
			$request->getHeaders(),
			$request->getBody(),
			$request->getProtocolVersion(),
		);

		return $new->withRequestTarget($request->getRequestTarget());
	}

}
