<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\GoalRevenue;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class GoalRevenueTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $goalRevenue = new GoalRevenue(123.45);

        self::assertEquals(['revenue' => 123.45], $goalRevenue->toParameters());
    }
}
