<?php declare(strict_types = 1);

namespace QaData\Psr7\Extra;

use JsonException;
use QaData\Psr7\Psr7Stream;
use function json_decode;
use const JSON_THROW_ON_ERROR;

/**
 * @method Psr7Stream getBody()
 */
trait ExtraRequestTrait
{

	public function getContents(): string
	{
		return $this->getBody()->getContents();
	}

	public function getContentsCopy(): string
	{
		$contents = $this->getContents();
		$this->getBody()->rewind();

		return $contents;
	}

	/**
	 * @throws JsonException
	 */
	public function getJsonBody(bool $assoc = true): mixed
	{
		return json_decode($this->getContents(), associative: $assoc, flags: JSON_THROW_ON_ERROR);
	}

	/**
	 * @throws JsonException
	 */
	public function getJsonBodyCopy(bool $assoc = true): mixed
	{
		$contents = $this->getJsonBody($assoc);
		$this->getBody()->rewind();

		return $contents;
	}

}
