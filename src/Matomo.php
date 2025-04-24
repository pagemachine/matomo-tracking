<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking;

use Pagemachine\MatomoTracking\Tracking\ActionFactoryInterface;
use Pagemachine\MatomoTracking\Tracking\ActionInterface;
use Pagemachine\MatomoTracking\Tracking\ActionTracker;
use Pagemachine\MatomoTracking\Tracking\InstanceInterface;
use Pagemachine\MatomoTracking\Tracking\TrackingException;
use Pagemachine\MatomoTracking\Tracking\TrackingPreference;
use Pagemachine\MatomoTracking\Tracking\TrackingRequestException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class Matomo implements InstanceInterface
{
    public function __construct(
        private readonly string $uri,
        private readonly ActionFactoryInterface $actionFactory,
        private readonly ActionTracker $tracker,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws TrackingException
     */
    public function track(ServerRequestInterface|ActionInterface $action): void
    {
        if ($action instanceof ServerRequestInterface) {
            $trackingPreference = TrackingPreference::fromRequest($action);

            if (!$trackingPreference->isAllowed) {
                $this->logger->notice('Tracking denied: {reason}', [
                    'reason' => $trackingPreference->reason,
                ]);

                return;
            }

            $attributes = $action->getAttribute('matomo.attributes', []);
            $action = $this->actionFactory->createActionFromRequest($action);

            foreach ($attributes as $attribute) {
                $action = $action->withAttribute($attribute);
            }
        }

        try {
            $this->tracker->track($this, $action);
        } catch (TrackingRequestException $e) {
            throw new TrackingException(sprintf('Tracking failed: %s', $e->getMessage()), 1743428624, $e);
        }
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
