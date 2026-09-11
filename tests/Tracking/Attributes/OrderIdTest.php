<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderIdTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderId = new OrderId('foo');

        self::assertEquals(['ec_id' => 'foo'], $orderId->toParameters());
    }
}
