<?php declare(strict_types = 1);

namespace Tests\Cases;

use QaData\Psr7\Psr7ServerRequestFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class Psr7ServerRequestFactoryTest extends TestCase
{

	public function testFromGlobal(): void
	{
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$request = Psr7ServerRequestFactory::fromGlobals();
		Assert::equal('POST', $request->getMethod());
	}

}

$test = new Psr7ServerRequestFactoryTest();
$test->run();
