<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Override value for the visitor IP (both IPv4 and IPv6 notations supported).
 */
final readonly class VisitorIpAddress implements AttributeInterface
{
    public function __construct(private string $visitorIpAddress)
    {
    }

    public function toParameters(): array
    {
        return ['cip' => $this->visitorIpAddress];
    }
}
