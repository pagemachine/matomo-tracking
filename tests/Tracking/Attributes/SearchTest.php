<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Search;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SearchTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $search = new Search('Test', 42);
        $expected = [
            'search' => 'Test',
            'search_count' => 42,
            'search_cat' => '',
            'ca' => 1,
        ];

        self::assertEquals($expected, iterator_to_array($search->toParameters()));

        $search = new Search('Test', 42, 'Something');
        $expected = [
            'search' => 'Test',
            'search_count' => 42,
            'search_cat' => 'Something',
            'ca' => 1,
        ];

        self::assertEquals($expected, iterator_to_array($search->toParameters()));
    }
}
