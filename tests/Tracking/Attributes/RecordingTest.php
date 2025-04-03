<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Recording;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RecordingTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $recording = new Recording();

        self::assertEquals(['rec' => 1], $recording->toParameters());
    }
}
