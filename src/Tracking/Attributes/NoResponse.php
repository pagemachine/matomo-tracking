<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Matomo will respond with an HTTP 204 response code instead of a GIF image.
 */
final class NoResponse implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['send_image' => 0];
    }
}
