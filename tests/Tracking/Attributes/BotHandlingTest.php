<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\BotHandling;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class BotHandlingTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $ignoreBotsHandling = BotHandling::IgnoreBots;

        self::assertEmpty($ignoreBotsHandling->toParameters());

        $autoHandling = BotHandling::Auto;

        self::assertEquals(['recMode' => 2], $autoHandling->toParameters());

        $botsOnlyHandling = BotHandling::BotsOnly;

        self::assertEquals(['recMode' => 1], $botsOnlyHandling->toParameters());

        $botsAsHumansHandling = BotHandling::BotsAsHumans;

        self::assertEquals(['bots' => 1], $botsAsHumansHandling->toParameters());
    }
}
