<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\SearchResultCount;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SearchResultCountTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $searchResultCount = new SearchResultCount(42);

        self::assertEquals(['search_count' => 42], $searchResultCount->toParameters());
    }
}
