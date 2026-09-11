<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Ecommerce;

final readonly class OrderItem implements \JsonSerializable
{
    public static function create(string $sku): self
    {
        return new self($sku);
    }

    public function withSku(string $sku): self
    {
        return new self(
            $sku,
            $this->name,
            $this->category,
            $this->price,
            $this->quantity,
        );
    }

    public function withName(string $name): self
    {
        return new self(
            $this->sku,
            $name,
            $this->category,
            $this->price,
            $this->quantity,
        );
    }

    public function withCategory(string $category): self
    {
        return new self(
            $this->sku,
            $this->name,
            $category,
            $this->price,
            $this->quantity,
        );
    }

    public function withPrice(float $price): self
    {
        return new self(
            $this->sku,
            $this->name,
            $this->category,
            $price,
            $this->quantity,
        );
    }

    public function withQuantity(int $quantity): self
    {
        return new self(
            $this->sku,
            $this->name,
            $this->category,
            $this->price,
            $quantity,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            $this->sku,
            $this->name,
            $this->category,
            $this->price,
            $this->quantity,
        ];
    }

    private function __construct(
        private string $sku,
        private string $name = '',
        private string $category = '',
        private float $price = 0,
        private int $quantity = 1,
    ) {
    }
}
