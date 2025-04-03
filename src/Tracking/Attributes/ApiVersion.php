<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Defines the api version to use (currently always set to 1)
 */
final class ApiVersion implements AttributeInterface
{
    public function toParameters(): array
    {
        return ['apiv' => 1];
    }
}
