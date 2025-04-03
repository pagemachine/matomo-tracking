<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\VisitorIpAddress;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisitorIpAddressTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $visitorIpAddress = new VisitorIpAddress('1.2.3.4');

        self::assertEquals(['cip' => '1.2.3.4'], $visitorIpAddress->toParameters());
    }
}
