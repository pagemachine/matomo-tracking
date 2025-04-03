<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Required for tracking, must be set to one.
 */
final class Recording implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['rec' => 1];
    }
}
