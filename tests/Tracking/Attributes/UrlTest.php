<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Url;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $url = new Url('https://example.org/current');

        self::assertEquals(['url' => 'https://example.org/current'], $url->toParameters());
    }
}
