# PSR-7 HTTP Message

`PSR-7` is HTTP message interface. It's very useful interface especially for middleware / relay pattern. Read more on official [PHP-FIG](http://www.php-fig.org/psr/psr-7/) website.

This package is based on a package from the guys at Contributte - [PSR-7 HTTP Message](https://github.com/contributte/psr7-http-message), which is based on [guzzle/psr7](https://github.com/guzzle/psr7).

---

## Usage

To install latest version of `qa-data/psr7-http-message` use [Composer](https://getcomposer.org).

```bash
composer require qa-data/psr7-http-message
```

## `Psr7Request`

The easiest way is to create request using `Psr7RequestFactory`.

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobals();
```

Additional methods (against PSR7 interface):

- of(RequestInterface $request): self
- getContents(): mixed
- getContentsCopy(): mixed
- getJsonBody(bool $associative = true): mixed
- getJsonBodyCopy(bool $associative = true): mixed

## `Psr7ServerRequest`

Additional methods (against PSR7 interface):

- of(ServerRequestInterface $request): self
- fromGlobals(): self
- withAttributes(array $attributes): self
- hasQueryParam(string $name): bool
- getQueryParam(string $name, mixed $default = null): mixed

## `Psr7Response`

The easiest way is to create request using `Psr7ResponseFactory`.

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7ResponseFactory::fromGlobal();
```

Additional methods (against PSR7 interface):

- of(ResponseInterface $response): self
- fromGlobals(): self
- appendBody(mixed $body): self
- rewindBody(): self
- writeBody(mixed $body): self
- writeJsonBody(array $data): self
- writeJsonObject(JsonSerializable $object): self
- getJsonBody(bool $associative = true): mixed
- getContents(bool $rewind = true): mixed
- withHeaders(array $headers): self
- send(): void
- sendHeaders(): void
- sendBody(): void

## API

**MessageInterface**

- `getProtocolVersion: string`
- `withProtocolVersion(string $version): static`
- `getHeaders(): array`
- `hasHeader(string $name): bool`
- `getHeader(string $name): string[]`
- `getHeaderLine(string $name): string`
- `withHeader(string $name, string|string[] $value): static`
- `withAddedHeader(string $name, string|string[] $value): static`
- `withoutHeader(string $name): static`
- `getBody(): StreamInterface`
- `withBody(StreamInterface $body): static`

**RequestInterface** << **MessageInterface**

- `getRequestTarget(): string`
- `withRequestTarget($requestTarget): static`
- `getMethod(): string`
- `withMethod(string $method): static`

**ServerRequestInterface** << **RequestInterface**

- `getServerParams(): array`
- `getCookieParams(): array`
- `withCookieParams(array $cookies): static`
- `getQueryParams(): array`
- `withQueryParams(array $query): static`
- `getUploadedFiles(): UploadedFileInterface[]`
- `withUploadedFiles(array $uploadedFiles): static`
- `getParsedBody(): mixed`
- `withParsedBody($data): static`
- `getAttributes(): mixed[]`
- `getAttribute(string $name, $default = null): mixed`
- `withAttribute(string $name, $value): static`
- `withoutAttribute(string $name): static`

**ResponseInterface** << **MessageInterface**

- `getStatusCode(): int`
- `withStatus(int $code, string $reasonPhrase = ''): static`
- `getReasonPhrase(): string`

**StreamInterface**

- `__toString(): string`
- `close(): void`
- `detach(): ?resource`
- `getSize(): ?int`
- `tell(): int`
- `eof(): bool`
- `isSeekable(): bool`
- `seek(int $offset, int $whence = SEEK_SET): void`
- `rewind(): void`
- `isWritable(): bool`
- `write($string): void`
- `isReadable(): bool`
- `read($length): string`
- `getContents(): string`
- `getMetadata(?string $key = null): mixed`

**UriInterface**

- `getScheme(): string`
- `withScheme(string $scheme): static`
- `getAuthority(): string`
- `getUserInfo(): string`
- `withUserInfo(string $user, ?string $password = null): static`
- `getHost(): string`
- `withHost(string $host): static`
- `getPort(): ?int`
- `withPort(?int $port): static`
- `getPath(): string`
- `withPath(string $path): static`
- `getQuery(): string`
- `withQuery(string $query): static`
- `getFragment(): string`
- `withFragment(string $fragment): static`
- `__toString(): string`

**UploadedFileInterface**

- `getStream(): StreamInterface`
- `moveTo($targetPath): void`
- `getSize(): ?int`
- `getError(): int`
- `getClientFilename(): ?string`
- `getClientMediaType(): ?string`
-
