<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\ReferrerUrl;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ReferrerUrlTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $referrerUrl = new ReferrerUrl('https://example.org/previous');

        self::assertEquals(['urlref' => 'https://example.org/previous'], $referrerUrl->toParameters());
    }
}
