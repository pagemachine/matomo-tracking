<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Discount offered.
 */
final readonly class OrderDiscount implements AttributeInterface
{
    public function __construct(private float $discount)
    {
    }

    public function toParameters(): array
    {
        return ['ec_dt' => $this->discount];
    }
}
