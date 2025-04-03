<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

use Pagemachine\MatomoTracking\Tracking\Attributes\ApiVersion;
use Pagemachine\MatomoTracking\Tracking\Attributes\NoResponse;
use Pagemachine\MatomoTracking\Tracking\Attributes\Random;
use Pagemachine\MatomoTracking\Tracking\Attributes\Recording;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;

final class ActionTracker
{
    public function __construct(
        private readonly UriFactoryInterface $uriFactory,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly ClientInterface $httpClient,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws TrackingRequestException
     */
    public function track(InstanceInterface $instance, ActionInterface $action): void
    {
        $action = $action
            ->withAttribute(new ApiVersion())
            ->withAttribute(new Recording())
            ->withAttribute(new Random())
            ->withAttribute(new NoResponse());
        $parameters = iterator_to_array($this->resolveParameters($action));

        if (empty($parameters['idsite'])) {
            $this->logger->warning('Tracking skipped: missing Matomo Site Id (idsite)');

            return;
        }

        $request = $this->requestFactory->createRequest(
            method: 'POST',
            uri: $this->resolveTrackerUri($instance),
        )->withHeader('content-type', 'application/x-www-form-urlencoded');

        $request->getBody()->write(http_build_query($parameters));

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TrackingRequestException(sprintf('Tracking request failed: %s', $e->getMessage()), 1737467578, $e);
        }

        if ($response->getStatusCode() >= 300) {
            throw new TrackingRequestException(sprintf('Tracking request failed: %s', $response->getBody()), 1737467578);
        }
    }

    private function resolveParameters(ActionInterface $action): \Generator
    {
        foreach ($action->getAttributes() as $attribute) {
            yield from $attribute->toParameters();
        }
    }

    private function resolveTrackerUri(InstanceInterface $instance): string
    {
        return (string)$this->uriFactory->createUri($instance->getUri())
            ->withPath('matomo.php');
    }
}
