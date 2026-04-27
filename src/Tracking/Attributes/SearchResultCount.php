<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The number of search results displayed on the results page.
 */
final readonly class SearchResultCount implements AttributeInterface
{
    public function __construct(private int $count)
    {
    }

    public function toParameters(): array
    {
        return ['search_count' => $this->count];
    }
}
