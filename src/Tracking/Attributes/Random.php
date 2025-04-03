<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Meant to hold a random value that is generated before each request. Using it helps avoid the tracking request being cached by the browser or a proxy.
 */
final class Random implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['rand' => uniqid(more_entropy: true)];
    }
}
