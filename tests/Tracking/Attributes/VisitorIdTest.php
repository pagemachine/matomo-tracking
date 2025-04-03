<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\VisitorId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisitorIdTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $visitorId = new VisitorId();

        $firstParameters = $visitorId->toParameters();

        self::assertArrayHasKey('_id', $firstParameters);
        self::assertIsString($firstParameters['_id']);
        self::assertStringMatchesFormat(str_repeat('%x', 16), $firstParameters['_id']);
    }

    #[Test]
    public function isConstant(): void
    {
        $visitorId = new VisitorId();

        $firstParameters = $visitorId->toParameters();
        $secondParameters = $visitorId->toParameters();

        self::assertEquals($firstParameters['_id'], $secondParameters['_id']);
    }
}
