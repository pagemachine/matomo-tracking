<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The ID of the website we're tracking a visit/action for.
 */
final readonly class SiteId implements AttributeInterface
{
    public function __construct(private string|int $siteId)
    {
    }

    public function toParameters(): array
    {
        return ['idsite' => $this->siteId];
    }
}
