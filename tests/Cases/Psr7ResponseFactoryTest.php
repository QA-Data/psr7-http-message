<?php declare(strict_types = 1);

namespace Tests\Cases;

use QaData\Psr7\Psr7ResponseFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class Psr7ResponseFactoryTest extends TestCase
{

	public function testFromGlobal(): void
	{
		$response = Psr7ResponseFactory::fromGlobal();
		$response = $response->withStatus(300);
		Assert::equal(300, $response->getStatusCode());
	}

}

$test = new Psr7ResponseFactoryTest();
$test->run();
