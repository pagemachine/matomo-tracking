<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Download;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DownloadTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $download = new Download('https://example.org/test.pdf');
        $expected = [
            'download' => 'https://example.org/test.pdf',
            'url' => 'https://example.org/test.pdf',
            'ca' => 1,
        ];

        self::assertEquals($expected, iterator_to_array($download->toParameters()));
    }
}
