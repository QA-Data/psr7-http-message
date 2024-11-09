<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use JsonSerializable;

class JsonObject implements JsonSerializable
{

	public function __construct(private readonly string $foo)
	{
	}

	/**
	 * @return array{foo: string}
	 */
	public function jsonSerialize(): array
	{
		return ['foo' => $this->foo];
	}

}
