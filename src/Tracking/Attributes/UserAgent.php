<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * An override value for the User-Agent HTTP header field. The user agent is used to detect the operating system and browser used.
 */
final class UserAgent implements AttributeInterface
{
    public function __construct(private readonly string $userAgent)
    {
    }

    public function toParameters(): array
    {
        return ['ua' => $this->userAgent];
    }
}
