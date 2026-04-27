<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The full URL for the current action.
 */
final readonly class Url implements AttributeInterface
{
    public function __construct(private string $url)
    {
    }

    public function toParameters(): array
    {
        return ['url' => $this->url];
    }
}
