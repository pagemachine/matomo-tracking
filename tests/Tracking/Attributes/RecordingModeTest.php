<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\RecordingMode;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RecordingModeTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $bodyOnlyRecording = RecordingMode::BotOnly;

        self::assertEquals(['recMode' => 1], $bodyOnlyRecording->toParameters());

        $autoRecording = RecordingMode::Auto;

        self::assertEquals(['recMode' => 2], $autoRecording->toParameters());
    }
}
