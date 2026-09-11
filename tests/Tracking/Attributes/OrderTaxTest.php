<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\OrderTax;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OrderTaxTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $orderTax = new OrderTax(123.45);

        self::assertEquals(['ec_tx' => 123.45], $orderTax->toParameters());
    }
}
