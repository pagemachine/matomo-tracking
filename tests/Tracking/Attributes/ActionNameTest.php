<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\ActionName;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ActionNameTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $actionName = new ActionName('Foo Bar');

        self::assertEquals(['action_name' => 'Foo Bar'], $actionName->toParameters());
    }
}
