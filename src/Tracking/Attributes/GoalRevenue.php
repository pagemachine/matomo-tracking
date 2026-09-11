<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * A monetary value that was generated as revenue by this goal conversion.
 *
 * E.g. the grand total for the ecommerce order (required when tracking an ecommerce order)
 */
final readonly class GoalRevenue implements AttributeInterface
{
    public function __construct(private float $grandTotal)
    {
    }

    public function toParameters(): array
    {
        return ['revenue' => $this->grandTotal];
    }
}
