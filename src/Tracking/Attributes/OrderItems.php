<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Items in the Ecommerce order
 */
final readonly class OrderItems implements AttributeInterface, \JsonSerializable
{
    public function __construct(private array $items)
    {
    }

    public function toParameters(): array
    {
        return ['ec_items' => json_encode($this, \JSON_THROW_ON_ERROR)];
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }
}
