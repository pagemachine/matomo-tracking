<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\NoResponse;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NoResponseTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $noResponse = new NoResponse();

        self::assertEquals(['send_image' => 0], $noResponse->toParameters());
    }
}
