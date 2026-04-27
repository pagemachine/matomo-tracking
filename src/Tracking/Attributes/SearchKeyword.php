<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The site search keyword.
 */
final readonly class SearchKeyword implements AttributeInterface
{
    public function __construct(private string $keyword)
    {
    }

    public function toParameters(): array
    {
        return ['search' => $this->keyword];
    }
}
