<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests;

use donatj\MockWebServer\DelayedResponse;
use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\RequestOptions;
use Pagemachine\MatomoTracking\Matomo;
use Pagemachine\MatomoTracking\Tracking\ActionFactory;
use Pagemachine\MatomoTracking\Tracking\ActionFactoryInterface;
use Pagemachine\MatomoTracking\Tracking\ActionInterface;
use Pagemachine\MatomoTracking\Tracking\ActionTracker;
use Pagemachine\MatomoTracking\Tracking\Attributes\ActionName;
use Pagemachine\MatomoTracking\Tracking\Attributes\AuthToken;
use Pagemachine\MatomoTracking\Tracking\Attributes\Language;
use Pagemachine\MatomoTracking\Tracking\Attributes\ReferrerUrl;
use Pagemachine\MatomoTracking\Tracking\Attributes\SiteId;
use Pagemachine\MatomoTracking\Tracking\Attributes\Url;
use Pagemachine\MatomoTracking\Tracking\Attributes\UserAgent;
use Pagemachine\MatomoTracking\Tracking\Attributes\VisitorIpAddress;
use Pagemachine\MatomoTracking\Tracking\TrackingException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\NullLogger;

final class TrackingTest extends TestCase
{
    private MockWebServer $mockMatomoServer;

    private Matomo $matomo;

    private ActionFactoryInterface $actionFactory;

    private ServerRequestFactoryInterface $serverRequestFactory;

    private const HTTP_CLIENT_TIMEOUT_SECONDS = 0.5;

    public function setUp(): void
    {
        $this->mockMatomoServer = new MockWebServer();
        $this->mockMatomoServer->start();

        $this->actionFactory = new ActionFactory();
        $this->serverRequestFactory = $httpFactory = new HttpFactory();

        $this->matomo = new Matomo(
            $this->mockMatomoServer->getServerRoot(),
            $this->actionFactory,
            new ActionTracker(
                $httpFactory,
                $httpFactory,
                new Client([
                    RequestOptions::TIMEOUT => self::HTTP_CLIENT_TIMEOUT_SECONDS,
                ]),
                new NullLogger(),
            ),
            new NullLogger(),
        );
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function tracksWithEssentials(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('apiv', $parameters);
        self::assertSame('1', $parameters['apiv']);
        self::assertArrayHasKey('rec', $parameters);
        self::assertSame('1', $parameters['rec']);
        self::assertArrayHasKey('send_image', $parameters);
        self::assertSame('0', $parameters['send_image']);
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function tracksWithRandomValue(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters1 = $this->mockMatomoServer->getLastRequest()->getPost();

        $this->matomo->track($action);

        $parameters2 = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('rand', $parameters1);
        self::assertArrayHasKey('rand', $parameters2);
        self::assertNotEquals($parameters1['rand'], $parameters2['rand']);
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function tracksWithSiteId(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('idsite', $parameters);
        self::assertSame('1', $parameters['idsite']);
    }

    #[Test]
    #[DataProvider('emptyActions')]
    public function skipsWithoutSiteId(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        self::assertNull($this->mockMatomoServer->getLastRequest());
    }

    #[Test]
    #[DataProvider('urlActions')]
    public function tracksWithUrls(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('url', $parameters);
        self::assertSame('http://example.com/test', $parameters['url']);
        self::assertArrayHasKey('urlref', $parameters);
        self::assertSame('http://example.com/previous', $parameters['urlref']);
    }

    #[Test]
    #[DataProvider('namedActions')]
    public function tracksWithActionName(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('action_name', $parameters);
        self::assertSame('Example Action', $parameters['action_name']);
    }

    #[Test]
    #[DataProvider('userAgentActions')]
    public function tracksWithUserAgent(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('ua', $parameters);
        self::assertSame('Example User Agent', $parameters['ua']);
    }

    #[Test]
    #[DataProvider('languageActions')]
    public function tracksWithLanguage(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('lang', $parameters);
        self::assertSame('en-US,en;q=0.9,de;q=0.8', $parameters['lang']);
    }

    #[Test]
    public function tracksActionsWithVisitorId(): void
    {
        $action1 = $this->actionFactory->createAction()
            ->withAttribute(new SiteId(1));

        $this->matomo->track($action1);

        $action1Parameters1 = $this->mockMatomoServer->getLastRequest()->getPost();

        $this->matomo->track($action1);

        $action1Parameters2 = $this->mockMatomoServer->getLastRequest()->getPost();

        $action2 = $this->actionFactory->createAction()
            ->withAttribute(new SiteId(1));

        $this->matomo->track($action2);

        $action2Parameters1 = $this->mockMatomoServer->getLastRequest()->getPost();

        $this->matomo->track($action2);

        $action2Parameters2 = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('_id', $action1Parameters1);
        self::assertArrayHasKey('_id', $action1Parameters2);
        self::assertArrayHasKey('_id', $action2Parameters1);
        self::assertArrayHasKey('_id', $action2Parameters2);
        self::assertEquals($action1Parameters1['_id'], $action1Parameters2['_id']);
        self::assertEquals($action2Parameters1['_id'], $action2Parameters2['_id']);
        self::assertNotEquals($action1Parameters1['_id'], $action2Parameters1['_id']);
    }

    #[Test]
    public function tracksServerRequestsWithVisitorId(): void
    {
        $serverRequest1 = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withAttribute('matomo.attributes', [new SiteId(1)]);

        $this->matomo->track($serverRequest1);

        $serverRequest1Parameters1 = $this->mockMatomoServer->getLastRequest()->getPost();

        $this->matomo->track($serverRequest1);

        $serverRequest1Parameters2 = $this->mockMatomoServer->getLastRequest()->getPost();

        $serverRequest2 = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withAttribute('matomo.attributes', [new SiteId(1)]);

        $this->matomo->track($serverRequest2);

        $serverRequest2Parameters1 = $this->mockMatomoServer->getLastRequest()->getPost();

        $this->matomo->track($serverRequest2);

        $serverRequest2Parameters2 = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('_id', $serverRequest1Parameters1);
        self::assertArrayHasKey('_id', $serverRequest1Parameters2);
        self::assertArrayHasKey('_id', $serverRequest2Parameters1);
        self::assertArrayHasKey('_id', $serverRequest2Parameters2);
        self::assertNotEquals($serverRequest1Parameters1['_id'], $serverRequest1Parameters2['_id']);
        self::assertNotEquals($serverRequest1Parameters1['_id'], $serverRequest2Parameters1['_id']);
        self::assertNotEquals($serverRequest1Parameters1['_id'], $serverRequest2Parameters2['_id']);
        self::assertNotEquals($serverRequest2Parameters1['_id'], $serverRequest2Parameters2['_id']);
    }

    #[Test]
    #[DataProvider('visitorIpActions')]
    public function tracksWithVisitorIpAddress(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('cip', $parameters);
        self::assertSame('2.3.4.5', $parameters['cip']);
        self::assertArrayHasKey('token_auth', $parameters);
        self::assertSame('ceff8d439e32d680caa830c59337f7e5', $parameters['token_auth']);
    }

    #[Test]
    public function tracksServerRequestsWithAttributesAndCustomActionFactory(): void
    {
        $customActionFactory = new class ($this->actionFactory) implements ActionFactoryInterface {
            public function __construct(private readonly ActionFactoryInterface $decorated)
            {
            }

            public function createAction(): ActionInterface
            {
                return $this->decorated->createAction();
            }

            public function createActionFromRequest(ServerRequestInterface $serverRequest): ActionInterface
            {
                return $this->decorated->createActionFromRequest($serverRequest)
                    ->withAttribute(new Url('http://example.com/custom-factory'));
            }
        };

        $httpFactory = new HttpFactory();

        $matomo = new Matomo(
            $this->mockMatomoServer->getServerRoot(),
            $customActionFactory,
            new ActionTracker(
                $httpFactory,
                $httpFactory,
                new Client([
                    RequestOptions::TIMEOUT => self::HTTP_CLIENT_TIMEOUT_SECONDS,
                ]),
                new NullLogger(),
            ),
            new NullLogger(),
        );

        $serverRequest = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withAttribute('matomo.attributes', [
                new SiteId(1),
                new Url('http://example.com/custom-url')
            ]);
        $matomo->track($serverRequest);

        $parameters = $this->mockMatomoServer->getLastRequest()->getPost();

        self::assertArrayHasKey('url', $parameters);
        self::assertSame('http://example.com/custom-url', $parameters['url']);
    }

    #[Test]
    public function tracksServerRequestsWithDoNotTrackDisabled(): void
    {
        $serverRequest = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withHeader('DNT', '0')
            ->withAttribute('matomo.attributes', [new SiteId(1)]);

        $this->matomo->track($serverRequest);

        self::assertNotEmpty($this->mockMatomoServer->getLastRequest());
    }

    #[Test]
    public function skipsServerRequestsWithDoNotTrackEnabled(): void
    {
        $serverRequest = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withHeader('DNT', '1')
            ->withAttribute('matomo.attributes', [new SiteId(1)]);

        $this->matomo->track($serverRequest);

        self::assertEmpty($this->mockMatomoServer->getLastRequest());
    }

    #[Test]
    public function skipsServerRequestsWithGlobalPrivacyControlEnabled(): void
    {
        $serverRequest = $this->serverRequestFactory->createServerRequest('GET', 'http://example.com/test')
            ->withHeader('Sec-GPC', '1')
            ->withAttribute('matomo.attributes', [new SiteId(1)]);

        $this->matomo->track($serverRequest);

        self::assertEmpty($this->mockMatomoServer->getLastRequest());
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function usesTrackerEndpoint(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $matomoRequest = $this->mockMatomoServer->getLastRequest();

        self::assertNotNull($matomoRequest);

        self::assertSame('/matomo.php', $matomoRequest->getRequestUri());
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function usesPostMethod(ActionInterface|ServerRequestInterface $action): void
    {
        $this->matomo->track($action);

        $matomoRequest = $this->mockMatomoServer->getLastRequest();

        self::assertNotNull($matomoRequest);

        self::assertSame('POST', $matomoRequest->getRequestMethod());

        self::assertNotEmpty($matomoRequest->getPost());
        self::assertEmpty($matomoRequest->getGet());
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function propagatesMatomoError(ActionInterface|ServerRequestInterface $action): void
    {
        $this->mockMatomoServer->setDefaultResponse(new Response(
            body: 'Bad Request',
            status: 400,
        ));

        self::expectException(TrackingException::class);
        self::expectExceptionCode(1743428624);

        $this->matomo->track($action);
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function propagatesRequestTimeout(ActionInterface|ServerRequestInterface $action): void
    {
        $delayInMicroseconds = self::HTTP_CLIENT_TIMEOUT_SECONDS * 1000000;

        $this->mockMatomoServer->setDefaultResponse(new DelayedResponse(
            response: new Response('DUMMY'),
            delay: (int)$delayInMicroseconds,
        ));

        self::expectException(TrackingException::class);
        self::expectExceptionCode(1743428624);

        $this->matomo->track($action);
    }

    #[Test]
    #[DataProvider('minimalActions')]
    public function propagatesConnectionError(ActionInterface|ServerRequestInterface $action): void
    {
        $this->mockMatomoServer->stop();

        self::expectException(TrackingException::class);
        self::expectExceptionCode(1743428624);

        $this->matomo->track($action);
    }

    public static function emptyActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction(),
        ];

        yield 'server request without attributes' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test'),
        ];

        yield 'server request with empty attributes' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test')
                ->withAttribute('matomo.attributes', []),
        ];
    }

    public static function minimalActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1)),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test')
                ->withAttribute('matomo.attributes', [new SiteId(1)]),
        ];
    }

    public static function namedActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1))
                ->withAttribute(new ActionName('Example Action')),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test')
                ->withAttribute('matomo.attributes', [
                    new SiteId(1),
                    new ActionName('Example Action'),
                ]),
        ];
    }

    public static function urlActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1))
                ->withAttribute(new Url('http://example.com/test'))
                ->withAttribute(new ReferrerUrl('http://example.com/previous')),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test', [
                'HTTP_REFERER' => 'http://example.com/previous',
            ])->withAttribute('matomo.attributes', [new SiteId(1)]),
        ];
    }

    public static function userAgentActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1))
                ->withAttribute(new UserAgent('Example User Agent')),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test')
                ->withHeader('user-agent', 'Example User Agent')
                ->withAttribute('matomo.attributes', [new SiteId(1)]),
        ];
    }

    public static function languageActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1))
                ->withAttribute(new Language('en-US,en;q=0.9,de;q=0.8')),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test')
                ->withHeader('accept-language', 'en-US,en;q=0.9,de;q=0.8')
                ->withAttribute('matomo.attributes', [new SiteId(1)]),
        ];
    }

    public static function visitorIpActions(): \Generator
    {
        yield 'action' => [
            (new ActionFactory())->createAction()
                ->withAttribute(new SiteId(1))
                ->withAttribute(new VisitorIpAddress('2.3.4.5'))
                ->withAttribute(new AuthToken('ceff8d439e32d680caa830c59337f7e5')),
        ];

        yield 'server request' => [
            (new HttpFactory())->createServerRequest('GET', 'http://example.com/test', [
                'REMOTE_ADDR' => '1.2.3.4',
            ])->withAttribute('matomo.attributes', [
                new SiteId(1),
                new VisitorIpAddress('2.3.4.5'),
                new AuthToken('ceff8d439e32d680caa830c59337f7e5'),
            ]),
        ];
    }
}
