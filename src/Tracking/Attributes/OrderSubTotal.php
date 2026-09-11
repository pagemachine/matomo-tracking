<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The sub total of the order; excludes shipping.
 */
final readonly class OrderSubTotal implements AttributeInterface
{
    public function __construct(private float $subTotal)
    {
    }

    public function toParameters(): array
    {
        return ['ec_st' => $this->subTotal];
    }
}
