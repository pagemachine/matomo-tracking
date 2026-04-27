<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * Represents all attributes of a download action
 */
final readonly class Download implements AttributeInterface
{
    public function __construct(private string $url)
    {
    }

    public function toParameters(): \Generator
    {
        yield from (new DownloadUrl($this->url))->toParameters();
        yield from (new Url($this->url))->toParameters();
        yield from (new CustomAction())->toParameters();
    }
}
