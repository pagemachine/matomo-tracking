<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\CustomAction;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CustomActionTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $customAction = new CustomAction();

        self::assertEquals(['ca' => 1], $customAction->toParameters());
    }
}
