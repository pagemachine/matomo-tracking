<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Tax amount of the order.
 */
final readonly class OrderTax implements AttributeInterface
{
    public function __construct(private float $tax)
    {
    }

    public function toParameters(): array
    {
        return ['ec_tx' => $this->tax];
    }
}
