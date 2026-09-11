<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;
use Pagemachine\MatomoTracking\Tracking\Ecommerce\OrderItem;

/**
 * An ecommerce order
 */
final readonly class Order implements AttributeInterface
{
    public static function create(): self
    {
        return new self();
    }

    public function withId(string $id): self
    {
        return new self([
            ...$this->attributes,
            new OrderId($id),
        ]);
    }

    public function withItems(OrderItem ...$items): self
    {
        return new self([
            ...$this->attributes,
            new OrderItems($items),
        ]);
    }

    public function withGrandTotal(float $grandTotal): self
    {
        return new self([
            ...$this->attributes,
            new GoalRevenue($grandTotal),
        ]);
    }

    public function withSubTotal(float $subTotal): self
    {
        return new self([
            ...$this->attributes,
            new OrderSubTotal($subTotal),
        ]);
    }

    public function withTax(float $tax): self
    {
        return new self([
            ...$this->attributes,
            new OrderTax($tax),
        ]);
    }

    public function withShippingCosts(float $shippingCosts): self
    {
        return new self([
            ...$this->attributes,
            new OrderShippingCosts($shippingCosts),
        ]);
    }

    public function withDiscount(float $discount): self
    {
        return new self([
            ...$this->attributes,
            new OrderDiscount($discount),
        ]);
    }

    public function toParameters(): \Generator
    {
        yield from (new GoalId(0))->toParameters();

        foreach ($this->attributes as $attribute) {
            yield from $attribute->toParameters();
        }
    }

    private function __construct(private array $attributes = [])
    {
    }
}
