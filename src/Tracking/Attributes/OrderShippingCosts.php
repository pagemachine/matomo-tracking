<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Shipping cost of the order.
 */
final readonly class OrderShippingCosts implements AttributeInterface
{
    public function __construct(private float $shippingCosts)
    {
    }

    public function toParameters(): array
    {
        return ['ec_sh' => $this->shippingCosts];
    }
}
