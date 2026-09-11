<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderDiscount;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderDiscountTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderDiscount = new OrderDiscount(123.45);

        self::assertEquals(['ec_dt' => 123.45], $orderDiscount->toParameters());
    }
}
