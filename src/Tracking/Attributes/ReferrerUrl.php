<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The full HTTP Referrer URL. This value is used to determine how someone got to your website (ie, through a website, search engine or campaign).
 */
final class ReferrerUrl implements AttributeInterface
{
    public function __construct(private readonly string $referrerUrl)
    {
    }

    public function toParameters(): array
    {
        return ['urlref' => $this->referrerUrl];
    }
}
