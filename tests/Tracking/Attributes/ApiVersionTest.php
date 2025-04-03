<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\ApiVersion;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ApiVersionTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $apiVersion = new ApiVersion();

        self::assertEquals(['apiv' => 1], $apiVersion->toParameters());
    }
}
