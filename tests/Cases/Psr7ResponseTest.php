<?php declare(strict_types = 1);

namespace Tests\Cases;

use QaData\Psr7\Psr7Response;
use Tester\Assert;
use Tester\TestCase;
use Tests\Fixtures\JsonObject;
use function assert;

require_once __DIR__ . '/../bootstrap.php';

final class Psr7ResponseTest extends TestCase
{

	private Psr7Response $response;

	public function testGedBody(): void
	{
		$this->response->getBody()->write('foo');
		$this->response->getBody()->write('bar');
		$this->response->getBody()->rewind();
		Assert::equal('foobar', $this->response->getBody()->getContents());
	}

	public function testGetContents(): void
	{
		$this->response->writeBody('FOO');

		Assert::equal('FOO', $this->response->getContents());
	}

	public function testWriteBody(): void
	{
		$this->response->writeBody('FOO');
		Assert::equal('FOO', $this->response->getContents());

		$this->response->writeBody('BAR');
		Assert::equal('FOOBAR', $this->response->getContents());
	}

	public function testWriteJsonBody(): void
	{
		$this->response = $this->response->writeJsonBody(['foo' => 'bar']);
		Assert::equal(['foo' => 'bar'], $this->response->getJsonBody());
	}

	public function testWriteJsonBodyUtf8(): void
	{
		$this->response = $this->response->writeJsonBody(['foo' => 'ěščřžýáíé']);
		Assert::equal(['foo' => 'ěščřžýáíé'], $this->response->getJsonBody());
	}

	public function testWriteJsonObject(): void
	{
		$jsonObject = new JsonObject('bar');
		$this->response = $this->response->writeJsonObject($jsonObject);
		Assert::equal(['foo' => 'bar'], $this->response->getJsonBody());
	}

	public function testWriteJsonObjectUtf8(): void
	{
		$jsonObject = new JsonObject('ěščřžýáíé');
		$this->response = $this->response->writeJsonObject($jsonObject);
		Assert::equal(['foo' => 'ěščřžýáíé'], $this->response->getJsonBody());
	}

	public function testAppendBody(): void
	{
		$this->response->writeBody('FOO');
		$this->response->appendBody('BAR');

		Assert::equal('FOOBAR', $this->response->getContents());
	}

	public function testWithAttributes(): void
	{
		$this->response = $this->response
			->withHeaders(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

		Assert::equal('bar', $this->response->getHeaderLine('X-Foo'));
		Assert::equal('baz', $this->response->getHeaderLine('X-Bar'));
	}

	public function testOf(): void
	{
		$this->response = $this->response
			->withStatus(205)
			->withHeader('X-Foo', 'bar')
			->writeBody('FOOBAR');

		Assert::equal('FOOBAR', $this->response->getContents());

		$clone = Psr7Response::of($this->response);

		Assert::equal(205, $clone->getStatusCode());
		Assert::equal('FOOBAR', $clone->getContents()); // @phpstan-ignore-line
	}

	protected function setUp(): void
	{
		parent::setUp();

		$response = Psr7Response::fromGlobals();
		assert($response instanceof Psr7Response);
		$this->response = $response;
	}

}

$test = new Psr7ResponseTest();
$test->run();
