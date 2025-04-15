<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\DownloadUrl;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DownloadUrlTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $downloadUrl = new DownloadUrl('https://example.org/test.pdf');

        self::assertEquals(['download' => 'https://example.org/test.pdf'], $downloadUrl->toParameters());
    }
}
