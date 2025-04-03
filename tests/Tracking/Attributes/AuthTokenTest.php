<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tests\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\Attributes\AuthToken;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AuthTokenTest extends TestCase
{
    #[Test]
    public function resolvesToParameters(): void
    {
        $actionName = new AuthToken('dfa7e1632be385829bf98fbd5a00ce80');

        self::assertEquals(['token_auth' => 'dfa7e1632be385829bf98fbd5a00ce80'], $actionName->toParameters());
    }
}
