<?php declare(strict_types = 1);

namespace QaData\Psr7;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use QaData\Psr7\Extra\ExtraServerRequestTrait;
use function function_exists;
use function getallheaders;
use function str_replace;

/**
 * @method array<Psr7UploadedFile> getUploadedFiles()
 */
class Psr7ServerRequest extends ServerRequest
{

	use ExtraServerRequestTrait;

	public static function of(ServerRequestInterface $request): ServerRequestInterface
	{
		$new = new self(
			$request->getMethod(),
			$request->getUri(),
			$request->getHeaders(),
			$request->getBody(),
			$request->getProtocolVersion(),
			$request->getServerParams(),
		);

		return $new->withAttributes($request->getAttributes())
			->withCookieParams($request->getCookieParams())
			->withRequestTarget($request->getRequestTarget())
			->withUploadedFiles($request->getUploadedFiles())
			->withQueryParams($request->getQueryParams());
	}

	public static function fromGlobals(): ServerRequestInterface
	{
		$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
		$headers = function_exists('getallheaders') ? getallheaders() : [];
		$uri = self::getUriFromGlobals();
		$body = new LazyOpenStream('php://input', 'r+');
		$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';

		$serverRequest = new self($method, $uri, $headers, $body, $protocol, $_SERVER);

		return $serverRequest
			->withCookieParams($_COOKIE)
			->withQueryParams($_GET)
			->withParsedBody($_POST)
			->withUploadedFiles(self::normalizeFiles($_FILES));
	}

	/**
	 * @param array<mixed> $attributes
	 */
	public function withAttributes(array $attributes): static
	{
		$new = $this;

		foreach ($attributes as $key => $value) {
			$new = $new->withAttribute($key, $value);
		}

		return $new;
	}

}
