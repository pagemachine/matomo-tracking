<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\Language;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class LanguageTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $language = new Language('en,de');

        self::assertEquals(['lang' => 'en,de'], $language->toParameters());
    }
}
