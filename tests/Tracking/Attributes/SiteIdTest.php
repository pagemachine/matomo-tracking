<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\SiteId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

final class SiteIdTest extends TestCase
{
    #[Test]
    #[TestWith(['42'])]
    #[TestWith([42])]
    public function resolvesToParameters(mixed $id): void
    {
        $siteId = new SiteId($id);

        self::assertEquals(['idsite' => $id], $siteId->toParameters());
    }
}
