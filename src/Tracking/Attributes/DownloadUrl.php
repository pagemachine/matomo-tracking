<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * URL of a file the user has downloaded. Used for tracking downloads.
 */
final readonly class DownloadUrl implements AttributeInterface
{
    public function __construct(private string $url)
    {
    }

    public function toParameters(): array
    {
        return ['download' => $this->url];
    }
}
