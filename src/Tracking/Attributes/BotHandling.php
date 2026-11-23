<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Desired tracking audience
 */
enum BotHandling implements AttributeInterface
{
    /**
     * Track human visits only, ignore bots
     */
    case IgnoreBots;

    /**
     * Track bots only, ignore human visits
     */
    case BotsOnly;

    /**
     * Track bots as human visits
     */
    case BotsAsHumans;

    /**
     * Track human visits and bots separately
     */
    case Auto;

    public function toParameters(): array
    {
        return match ($this) {
            self::IgnoreBots => [],
            self::BotsOnly => RecordingMode::BotsOnly->toParameters(),
            self::BotsAsHumans => (new BotTracking())->toParameters(),
            self::Auto => RecordingMode::Auto->toParameters(),
        };
    }
}
