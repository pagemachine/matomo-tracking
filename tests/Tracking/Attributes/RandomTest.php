<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Random;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RandomTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $random = new Random();

        $firstParameters = $random->toParameters();

        self::assertArrayHasKey('rand', $firstParameters);

        $secondParameters = $random->toParameters();

        self::assertArrayHasKey('rand', $secondParameters);

        self::assertNotEquals($firstParameters, $secondParameters);
    }
}
