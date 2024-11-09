<?php declare(strict_types = 1);

namespace Tests\Cases;

use GuzzleHttp\Psr7\Utils;
use QaData\Psr7\ProxyRequest;
use QaData\Psr7\Psr7ServerRequest;
use QaData\Psr7\Psr7ServerRequestFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class ProxyRequestTest extends TestCase
{

	private const HeaderContentType = 'Content-Type';

	private const HeaderHost = 'Host';

	private ProxyRequest $proxy;

	private Psr7ServerRequest $request;

	public function testWithProtocolVersion(): void
	{
		$modifiedProxy = $this->proxy->withProtocolVersion('1.1');

		Assert::equal('1.1', $modifiedProxy->getProtocolVersion());
		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([
			self::HeaderHost => ['localhost'],
			self::HeaderContentType => ['application/json'],
		], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same('localhost', $modifiedProxy->getHeaderLine(self::HeaderHost));
		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithAddedHeader(): void
	{
		$modifiedProxy = $this->proxy->withAddedHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([
			self::HeaderHost => ['localhost'],
			self::HeaderContentType => ['application/json'],
		], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same('localhost', $modifiedProxy->getHeaderLine(self::HeaderHost));
		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithoutHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([
			self::HeaderHost => ['localhost'],
			self::HeaderContentType => ['application/json'],
		], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));

		$modifiedProxy = $modifiedProxy->withoutHeader(self::HeaderContentType);

		Assert::false($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same([], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([
			self::HeaderHost => ['localhost'],
		], $modifiedProxy->getHeaders());
		Assert::same('', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithBody(): void
	{
		Assert::same(
			'foo',
			$this->proxy->withBody(Utils::streamFor('foo'))->getContents(),
		);
		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->request = Psr7ServerRequestFactory::fromGlobals();
		$this->proxy = new ProxyRequest($this->request);
	}

}

$test = new ProxyRequestTest();
$test->run();
