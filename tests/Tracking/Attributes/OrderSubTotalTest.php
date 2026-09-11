<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderSubTotal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderSubTotalTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderSubTotal = new OrderSubTotal(123.45);

        self::assertEquals(['ec_st' => 123.45], $orderSubTotal->toParameters());
    }
}
