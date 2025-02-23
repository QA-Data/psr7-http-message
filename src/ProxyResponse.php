<?php declare(strict_types = 1);

namespace QaData\Psr7;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use QaData\Psr7\Extra\ExtraResponseTrait;

class ProxyResponse implements ResponseInterface
{

	use ExtraResponseTrait;

	public function __construct(protected ResponseInterface $inner)
	{
	}

	public function getOriginalResponse(): ResponseInterface
	{
		return $this->inner;
	}

	public function getProtocolVersion(): string
	{
		return $this->inner->getProtocolVersion();
	}

	public function withProtocolVersion(string $version): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withProtocolVersion($version);

		return $new;
	}

	/**
	 * @return array<array<string>>
	 */
	public function getHeaders(): array
	{
		return $this->inner->getHeaders();
	}

	public function hasHeader(string $name): bool
	{
		return $this->inner->hasHeader($name);
	}

	/**
	 * @return array<string>
	 */
	public function getHeader(string $name): array
	{
		return $this->inner->getHeader($name);
	}

	public function getHeaderLine(string $name): string
	{
		return $this->inner->getHeaderLine($name);
	}

	/**
	 * @param string|array<string> $value
	 *
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
	 */
	public function withHeader(string $name, $value): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withHeader($name, $value);

		return $new;
	}

	/**
	 * @param string|array<string> $value
	 *
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
	 */
	public function withAddedHeader(string $name, $value): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withAddedHeader($name, $value);

		return $new;
	}

	public function withoutHeader(string $name): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withoutHeader($name);

		return $new;
	}

	public function getBody(): StreamInterface
	{
		return $this->inner->getBody();
	}

	public function withBody(StreamInterface $body): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withBody($body);

		return $new;
	}

	public function getStatusCode(): int
	{
		return $this->inner->getStatusCode();
	}

	public function withStatus(int $code, string $reasonPhrase = ''): static
	{
		$new = clone $this;
		$new->inner = $this->inner->withStatus($code, $reasonPhrase);

		return $new;
	}

	public function getReasonPhrase(): string
	{
		return $this->inner->getReasonPhrase();
	}

}
