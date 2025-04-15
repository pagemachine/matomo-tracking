# Matomo Tracking API

Server-side tracking of actions (e.g. page views) in [Matomo](https://matomo.org)
using the [Matomo Tracking HTTP API](https://developer.matomo.org/api-reference/tracking-api).

## Features

* Framework-agnostic, uses
  [PSR-7: HTTP message interfaces](https://www.php-fig.org/psr/psr-7),
  [PSR-17: HTTP Factories](https://www.php-fig.org/psr/psr-17) and
  [PSR-18: HTTP Client](https://www.php-fig.org/psr/psr-18)
* Container/dependency injection friendly
* Track page views from server requests
* Track actions without requests
* Track visitor IP address (requires Matomo Auth Token)
* Attributes for tracking of Matomo Site Id, URL, etc.
* Add custom attributes

### Privacy by design

* Visitor IDs are random
* No cookies are set or forwarded
* Action attributes are sent to Matomo via `POST` to prevent
  them from showing up in access logs (thus no Log Analytics)
* Respects [Do Not Track](https://www.w3.org/TR/tracking-dnt/#dnt-header-field)
* Respects [Global Privacy Control](https://w3c.github.io/gpc/)

## Installation

    composer require pagemachine/matomo-tracking

## Usage

Actions can be tracked with the `Matomo` class. Make sure you have implementations
for `UriFactoryInterface`, `RequestFactoryInterface`, `ClientInterface` and `LoggerInterface`.

*You should configure the HTTP client with a sane timeout.* This ensures pages load
quickly in case a Matomo instance is not responding. Tracking will be skipped in
this case.

In case of most frameworks the dependency injection container will cover most
dependencies and you only need to manually configure the URL of your Matomo
instance. E.g. with Symfony:

```yaml
services:
  Pagemachine\MatomoTracking\Matomo:
    arguments:
      $uri: '%env(MATOMO_URL)%'
```

Then have `Matomo` injected:

```php
use Pagemachine\MatomoTracking\Matomo;

final class Example
{
    public function __construct(
        private readonly Matomo $matomo,
    ) {}

    public function someAction(): void
    {
        $this->matomo->track(...);
    }
}
```

Alternatively use standalone solutions like `guzzlehttp/guzzle`, `guzzlehttp/psr7`
and some useful logger or the PSR `NullLogger`:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\RequestOptions;
use Pagemachine\MatomoTracking\Matomo;
use Pagemachine\MatomoTracking\Tracking\ActionFactory;
use Pagemachine\MatomoTracking\Tracking\ActionTracker;
use Psr\Log\NullLogger;

$matomoUrl = 'https://...';
$httpFactory = new HttpFactory();

$matomo = new Matomo(
    $matomoUrl,
    new ActionFactory(),
    new ActionTracker(
        $httpFactory,
        $httpFactory,
        new Client([
            RequestOptions::TIMEOUT => 3,
        ]),
        new NullLogger(),
    ),
    new NullLogger(),
);

$matomo->track(...);
```

### Server requests

A PSR-7 `ServerRequestInterface` can directly be tracked as page view:

```php
use Pagemachine\MatomoTracking\Matomo;
use Pagemachine\MatomoTracking\Tracking\Attributes\ActionName;
use Pagemachine\MatomoTracking\Tracking\Attributes\SiteId;
use Psr\Http\Message\ServerRequestInterface;

final class Example
{
    public function __construct(
        private readonly Matomo $matomo,
    ) {}

    public function someAction(ServerRequestInterface $request): void
    {
        // Url attribute is determined from request
        $request = $request->withAttribute('matomo.attributes', [
            new SiteId(1),
            new ActionName('Some action'),
        ]));

        $this->matomo->track($request);
    }
}
```

As shown the custom `matomo.attributes` request attribute can be set for
tracking [attributes](#attributes).

By default URLs (current, referrer) and client info (user agent, language)
are determined from the server request.

### Actions

Aside from PSR-7 server requests, actions not directly related to a request can
also be tracked. Use the `ActionFactoryInterface` (frameworks) or the
`ActionFactory` (standalone) to track an action with [attributes](#attributes):

```php
use Pagemachine\MatomoTracking\Matomo;
use Pagemachine\MatomoTracking\Tracking\Attributes\ActionName;
use Pagemachine\MatomoTracking\Tracking\Attributes\SiteId;
use Pagemachine\MatomoTracking\Tracking\Attributes\Url;

final class Example
{
    public function __construct(
        private readonly Matomo $matomo,
        private readonly ActionFactoryInterface $actionFactory,
    ) {}

    public function someAction(): void
    {
        $action = $this->actionFactory->createAction()
            ->withAttribute(new SiteId(1))
            ->withAttribute(new Url('https://example.org/demo'))
            ->withAttribute(new ActionName('Demo Page'));

        $this->matomo->track($action);
    }
}
```

You can also create an action from a PSR-7 `ServerRequestInterface` if desired:

```php
use Pagemachine\MatomoTracking\Matomo;
use Pagemachine\MatomoTracking\Tracking\Attributes\ActionName;
use Pagemachine\MatomoTracking\Tracking\Attributes\SiteId;
use Psr\Http\Message\ServerRequestInterface;

final class Example
{
    public function __construct(
        private readonly Matomo $matomo,
        private readonly ActionFactoryInterface $actionFactory,
    ) {}

    public function someAction(ServerRequestInterface $request): void
    {
        // Url attribute is determined from request
        $action = $this->actionFactory->createActionFromRequest($request)
            ->withAttribute(new SiteId(1))
            ->withAttribute(new ActionName('Demo Page'));

        $this->matomo->track($action);
    }
}
```

### Action factories

If there are additional attributes which should be added to actions by default,
you can add a custom `ActionFactoryInterface`. This should wrap or [decorate](https://symfony.com/doc/current/service_container/service_decoration.html)
the default `ActionFactory` to ensure all default attributes are added:

```php
use Pagemachine\MatomoTracking\Tracking\ActionFactoryInterface;
use Pagemachine\MatomoTracking\Tracking\ActionInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleActionFactory implements ActionFactoryInterface
{
    public function __construct(
        private readonly ActionFactoryInterface $decorated,
    ) {}

    public function createAction(): ActionInterface
    {
        $action = $this->decorated->createAction()
            ->withAttribute(...);

        return $action;
    }

    public function createActionFromRequest(ServerRequestInterface $serverRequest): ActionInterface
    {
        $action = $this->decorated->createActionFromRequest($serverRequest)
            ->withAttribute(...);

        return $action;
    }
}
```

This pattern can be used to add the mandatory `SiteId` attribute to all tracked actions.

### Attributes

Attributes contain tracking values and cover one or more of the
[Matomo Tracking HTTP API](https://developer.matomo.org/api-reference/tracking-api)
parameters:

| Attribute | Matomo API parameters |
| --- | --- |
| `ActionName` | `action_name` |
| `ApiVersion` (*) | `apiv` |
| `AuthToken` | `token_auth` |
| `BotTracking` | `bots` |
| `CustomAction` | `ca` |
| `Download` | `download`, `url`, `ca` |
| `DownloadUrl` | `download` |
| `Language` | `lang` |
| `NoResponse` (*) | `send_image` |
| `Random` (*) | `rand` |
| `Recording` (*) | `rec` |
| `ReferrerUrl` | `urlref` |
| `SiteId` | `idsite` |
| `Url` | `url` |
| `UserAgent` | `ua` |
| `VisitorId` | `_id` |
| `VisitorIpAddress` | `cip` |

(Attributes marked with * are added internally and always sent.)

You **must** at least add a `SiteId` attribute for tracking in Matomo. All
other attributes may be used on demand.

Some attributes like `VisitorIpAddress` require an auth token
which must be provided with the `AuthToken` attribute. See
[Matomo Tracking HTTP API: Other parameters](https://developer.matomo.org/api-reference/tracking-api#other-parameters-require-authentication-via-token_auth)
for details when an auth token is required.

#### Custom attributes

Custom attributes can be added by implementing the `AttributeInterface`:

```php
use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

final class ExampleDimension implements AttributeInterface
{
    public function __construct(private string $example) {}

    public function toParameters(): iterable
    {
        return ['dimension1' => $this->example];
    }
}
```

The keys of the iterable (`array`, `\Generator`, etc.) returned by `toParameters()`
must be parameters of the [Matomo Tracking HTTP API](https://developer.matomo.org/api-reference/tracking-api).
