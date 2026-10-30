<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Required for tracking, must be set to one.
 */
enum RecordingMode implements AttributeInterface
{
    /**
     * Bot only
     *
     * Only bot tracking is performed. Non-bot requests are discarded.
     */
    case BotOnly;

    /**
     * Auto mode
     *
     * Matomo automatically decides whether to process the request as bot tracking or visit/action tracking.
     */
    case Auto;

    public function toParameters(): array
    {
        return match ($this) {
            self::BotOnly => ['recMode' => 1],
            self::Auto => ['recMode' => 2],
        };
    }
}
