<?php declare(strict_types = 1);

namespace Tests\Cases;

use QaData\Psr7\Exception\InvalidStateException;
use QaData\Psr7\Psr7ServerRequest;
use QaData\Psr7\Psr7ServerRequestFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class Psr7ServerRequestTest extends TestCase
{

	private Psr7ServerRequest $request;

	public function testOf(): void
	{
		$this->request = $this->request
			->withHeader('X-Foo', 'bar')
			->withMethod('PUT');

		Assert::equal('PUT', $this->request->getMethod());

		$clone = Psr7ServerRequest::of($this->request);

		Assert::equal('PUT', $clone->getMethod());
	}

	public function testWithAttributes(): void
	{
		$this->request = $this->request
			->withAttributes(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

		Assert::equal('GET', $this->request->getMethod());
		Assert::equal('bar', $this->request->getAttribute('X-Foo'));
		Assert::equal('baz', $this->request->getAttribute('X-Bar'));
	}

	public function testGetQueryParam(): void
	{
		$_GET['foo'] = 'bar';
		$this->request = Psr7ServerRequestFactory::fromGlobals();

		Assert::true($this->request->hasQueryParam('foo'));
		Assert::equal('bar', $this->request->getQueryParam('foo'));
		Assert::equal('baz', $this->request->getQueryParam('foobar', 'baz'));

		Assert::throws(function (): void {
			$this->request->getQueryParam('baz');
		}, InvalidStateException::class, 'No query parameter "baz" found');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->request = Psr7ServerRequestFactory::fromGlobals();
	}

}

$test = new Psr7ServerRequestTest();
$test->run();
