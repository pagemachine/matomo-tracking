<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The number of search results displayed on the results page.
 */
final class SearchResultCount implements AttributeInterface
{
    public function __construct(private readonly int $count)
    {
    }

    public function toParameters(): array
    {
        return ['search_count' => $this->count];
    }
}
