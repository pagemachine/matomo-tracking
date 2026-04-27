<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The category related to a search.
 */
final readonly class SearchCategory implements AttributeInterface
{
    public function __construct(private string $category)
    {
    }

    public function toParameters(): array
    {
        return ['search_cat' => $this->category];
    }
}
