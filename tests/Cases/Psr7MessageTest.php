<?php declare(strict_types = 1);

namespace Tests\Cases;

use QaData\Psr7\Psr7Message;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class Psr7MessageTest extends TestCase
{

	private Psr7Message $message;

	public function testGetHeaderLine(): void
	{
		Assert::equal('', $this->message->getHeaderLine('foo'));

		$this->message = $this->message->withAddedHeader('foo', 'bar');
		Assert::equal('bar', $this->message->getHeaderLine('foo'));
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->message = new Psr7Message();
	}

}

$test = new Psr7MessageTest();
$test->run();
