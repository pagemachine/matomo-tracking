<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderShippingCosts;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderShippingCostsTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderShippingCosts = new OrderShippingCosts(123.45);

        self::assertEquals(['ec_sh' => 123.45], $orderShippingCosts->toParameters());
    }
}
