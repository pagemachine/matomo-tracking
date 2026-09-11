<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * If specified, the tracking request will trigger a conversion for the goal of the website being tracked with this ID.
 */
final readonly class GoalId implements AttributeInterface
{
    public function __construct(private int $id)
    {
    }

    public function toParameters(): array
    {
        return ['idgoal' => $this->id];
    }
}
