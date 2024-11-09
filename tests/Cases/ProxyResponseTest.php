<?php declare(strict_types = 1);

namespace Tests\Cases;

use GuzzleHttp\Psr7\Utils;
use QaData\Psr7\ProxyResponse;
use QaData\Psr7\Psr7Response;
use QaData\Psr7\Psr7ResponseFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class ProxyResponseTest extends TestCase
{

	private const HeaderContentType = 'Content-Type';

	private ProxyResponse $proxy;

	private Psr7Response $response;

	public function testWithProtocolVersion(): void
	{
		$modifiedProxy = $this->proxy->withProtocolVersion('1.1');

		Assert::equal('1.1', $modifiedProxy->getProtocolVersion());
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([self::HeaderContentType => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithAddedHeader(): void
	{
		$modifiedProxy = $this->proxy->withAddedHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([self::HeaderContentType => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithoutHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HeaderContentType, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([self::HeaderContentType => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HeaderContentType));

		$modifiedProxy = $modifiedProxy->withoutHeader(self::HeaderContentType);

		Assert::false($modifiedProxy->hasHeader(self::HeaderContentType));
		Assert::same([], $modifiedProxy->getHeader(self::HeaderContentType));
		Assert::same([], $modifiedProxy->getHeaders());
		Assert::same('', $modifiedProxy->getHeaderLine(self::HeaderContentType));
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithBody(): void
	{
		Assert::same(
			'foo',
			$this->proxy->withBody(Utils::streamFor('foo'))->getContents(),
		);
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithStatus(): void
	{
		$modifiedProxy = $this->proxy->withStatus(200);

		Assert::same(200, $modifiedProxy->getStatusCode());
		Assert::same('OK', $modifiedProxy->getReasonPhrase());
		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->response = Psr7ResponseFactory::fromGlobal();
		$this->proxy = new ProxyResponse($this->response);
	}

}

$test = new ProxyResponseTest();
$test->run();
