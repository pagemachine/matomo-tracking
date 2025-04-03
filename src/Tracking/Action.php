<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

final class Action implements ActionInterface
{
    private array $attributes = [];

    public function getAttributes(): \Generator
    {
        yield from $this->attributes;
    }

    public function withAttribute(AttributeInterface $attribute): self
    {
        $clone = clone $this;
        $clone->attributes[] = $attribute;

        return $clone;
    }
}
