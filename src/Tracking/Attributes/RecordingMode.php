<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Visitor tracking mode
 */
enum RecordingMode implements AttributeInterface
{
    /**
     * Auto mode
     *
     * Matomo automatically decides whether to process the request as bot tracking or visit/action tracking.
     */
    case Auto;

    /**
     * Bots only
     *
     * Only bot tracking is performed. Non-bot requests are discarded.
     */
    case BotsOnly;

    public function toParameters(): array
    {
        return match ($this) {
            self::Auto => ['recMode' => 2],
            self::BotsOnly => ['recMode' => 1],
        };
    }
}
