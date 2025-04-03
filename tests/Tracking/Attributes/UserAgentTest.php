<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\UserAgent;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserAgentTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $userAgent = new UserAgent('Example Browser 1.0');

        self::assertEquals(['ua' => 'Example Browser 1.0'], $userAgent->toParameters());
    }
}
