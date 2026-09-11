<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderItems;
use Pagemachine\MatomoTracking\Tracking\Ecommerce\OrderItem;
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
            OrderItem::create('DEF')
                ->withName('structured')
                ->withPrice(45.67)
                ->withQuantity(3),
        ]);

        self::assertEquals(['ec_items' => '[["ABC","raw","",12.34,5],["DEF","structured","",45.67,3]]'], $orderItems->toParameters());
    }
}
