<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Order;
use Pagemachine\MatomoTracking\Tracking\Ecommerce\OrderItem;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $order = Order::create();

        self::assertEquals([
            'idgoal' => 0,
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithId(): void
    {
        $order = Order::create()->withId('ABC');

        self::assertEquals([
            'idgoal' => 0,
            'ec_id' => 'ABC',
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithItems(): void
    {
        $order = Order::create()->withItems(
            OrderItem::create('ABC')->withName('1st product')->withPrice(12.34)->withQuantity(5),
            OrderItem::create('DEF')->withName('2nd product')->withPrice(56.78)->withQuantity(3),
        );

        self::assertEquals([
            'idgoal' => 0,
            'ec_items' => '[["ABC","1st product","",12.34,5],["DEF","2nd product","",56.78,3]]',
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithGrandTotal(): void
    {
        $order = Order::create()->withGrandTotal(123.45);

        self::assertEquals([
            'idgoal' => 0,
            'revenue' => 123.45,
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithSubTotal(): void
    {
        $order = Order::create()->withSubTotal(123.45);

        self::assertEquals([
            'idgoal' => 0,
            'ec_st' => 123.45,
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithTax(): void
    {
        $order = Order::create()->withTax(123.45);

        self::assertEquals([
            'idgoal' => 0,
            'ec_tx' => 123.45,
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithShippingCosts(): void
    {
        $order = Order::create()->withShippingCosts(123.45);

        self::assertEquals([
            'idgoal' => 0,
            'ec_sh' => 123.45,
        ], iterator_to_array($order->toParameters()));
    }

    #[Test]
    public function resolvesWithDiscount(): void
    {
        $order = Order::create()->withDiscount(123.45);

        self::assertEquals([
            'idgoal' => 0,
            'ec_dt' => 123.45,
        ], iterator_to_array($order->toParameters()));
    }
}
