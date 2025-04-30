<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\SearchKeyword;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SearchKeywordTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $searchKeyword = new SearchKeyword('Test');

        self::assertEquals(['search' => 'Test'], $searchKeyword->toParameters());
    }
}
