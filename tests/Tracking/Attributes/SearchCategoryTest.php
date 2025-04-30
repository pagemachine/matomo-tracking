<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\SearchCategory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SearchCategoryTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $searchCategory = new SearchCategory('Something');

        self::assertEquals(['search_cat' => 'Something'], $searchCategory->toParameters());
    }
}
