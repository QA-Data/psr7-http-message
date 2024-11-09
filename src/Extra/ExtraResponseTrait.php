<?php declare(strict_types = 1);

namespace QaData\Psr7\Extra;

use JsonSerializable;
use QaData\Psr7\Psr7Stream;
use function json_decode;
use function json_encode;
use const JSON_THROW_ON_ERROR;

/**
 * @method Psr7Stream getBody()
 */
trait ExtraResponseTrait
{

	public function appendBody(string $body): static
	{
		$this->getBody()->write($body);

		return $this;
	}

	public function rewindBody(): static
	{
		$this->getBody()->rewind();

		return $this;
	}

	public function writeBody(string $body): static
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param array<mixed> $data
	 */
	public function writeJsonBody(array $data): static
	{
		return $this
			->writeBody(json_encode($data, flags: JSON_THROW_ON_ERROR))
			->withHeader('Content-Type', 'application/json');
	}

	public function writeJsonObject(JsonSerializable $object): static
	{
		return $this
			->writeBody(json_encode($object, flags: JSON_THROW_ON_ERROR))
			->withHeader('Content-Type', 'application/json');
	}

	public function getJsonBody(bool $assoc = true): mixed
	{
		return json_decode($this->getContents(), associative: $assoc, flags: JSON_THROW_ON_ERROR);
	}

	public function getContents(bool $rewind = true): string
	{
		if ($rewind) {
			$this->rewindBody();
		}

		return $this->getBody()->getContents();
	}

	/**
	 * @param array<string, string>|array<string> $headers
	 */
	public function withHeaders(array $headers): static
	{
		$new = clone $this;

		foreach ($headers as $key => $value) {
			$new = $new->withHeader($key, $value);
		}

		return $new;
	}

}
