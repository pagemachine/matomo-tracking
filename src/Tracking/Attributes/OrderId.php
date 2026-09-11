<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The unique string identifier for the ecommerce order (required when tracking an ecommerce order).
 */
final readonly class OrderId implements AttributeInterface
{
    public function __construct(private string $id)
    {
    }

    public function toParameters(): array
    {
        return ['ec_id' => $this->id];
    }
}
