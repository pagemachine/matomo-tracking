<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\GoalId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class GoalIdTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $goalId = new GoalId(42);

        self::assertEquals(['idgoal' => 42], $goalId->toParameters());
    }
}
