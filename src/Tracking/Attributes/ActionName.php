<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The title of the action being tracked. For page tracks this is used as page title.
 */
final class ActionName implements AttributeInterface
{
    public function __construct(private readonly string $actionName)
    {
    }

    public function toParameters(): array
    {
        return ['action_name' => $this->actionName];
    }
}
