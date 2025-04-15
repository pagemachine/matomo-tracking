<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Stands for custom action, can be optionally sent along any tracking request that isn't a page view.
 */
final class CustomAction implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['ca' => 1];
    }
}
