<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

interface ActionInterface
{
    public function getAttributes(): iterable;

    public function withAttribute(AttributeInterface $attribute): self;
}
