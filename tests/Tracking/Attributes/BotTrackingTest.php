<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\BotTracking;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class BotTrackingTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $botTracking = new BotTracking();

        self::assertEquals(['bots' => 1], $botTracking->toParameters());
    }
}
