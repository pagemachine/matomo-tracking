<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Enable tracking of bots as normal visits/actions
 */
final class BotTracking implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['bots' => 1];
    }
}
