<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * 32 character authorization key used to authenticate the API request.
 */
final readonly class AuthToken implements AttributeInterface
{
    public function __construct(
        #[\SensitiveParameter]
        private string $authToken,
    ) {
    }

    public function toParameters(): array
    {
        return ['token_auth' => $this->authToken];
    }
}
