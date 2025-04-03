<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

interface AttributeInterface
{
    public function toParameters(): iterable;
}
