<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * An override value for the Accept-Language HTTP header field. This value is used to detect the visitor's country if GeoIP is not enabled.
 */
final class Language implements AttributeInterface
{
    public function __construct(private readonly string $language)
    {
    }

    public function toParameters(): array
    {
        return ['lang' => $this->language];
    }
}
