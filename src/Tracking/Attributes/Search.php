<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * A site search.
 */
final readonly class Search implements AttributeInterface
{
    public function __construct(
        private string $keyword,
        private int $count,
        private string $category = '',
    ) {
    }

    public function toParameters(): \Generator
    {
        yield from (new SearchKeyword($this->keyword))->toParameters();
        yield from (new SearchResultCount($this->count))->toParameters();
        yield from (new SearchCategory($this->category))->toParameters();
        yield from (new CustomAction())->toParameters();
    }
}
