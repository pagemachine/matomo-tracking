<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderItems;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderItemsTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderItems = new OrderItems([]);

        self::assertEquals(['ec_items' => '[]'], $orderItems->toParameters());

        $orderItems = new OrderItems([
            ['ABC', 'raw', '', 12.34, 5],
        ]);

        self::assertEquals(['ec_items' => '[["ABC","raw","",12.34,5]]'], $orderItems->toParameters());
    }
}
