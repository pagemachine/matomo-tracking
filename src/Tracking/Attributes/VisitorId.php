<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking\Attributes;

use Pagemachine\MatomoTracking\Tracking\AttributeInterface;

/**
 * The unique visitor ID, must be a 16 characters hexadecimal string. Every unique visitor must be assigned a different ID and this ID must not change after it is assigned.
 */
final class VisitorId implements AttributeInterface
{
    private const VISITOR_ID_BYTES = 8;

    private readonly string $visitorId;

    public function __construct()
    {
        $this->visitorId = $this->generateRandomVisitorId();
    }

    public function toParameters(): array
    {
        return ['_id' => $this->visitorId];
    }

    private function generateRandomVisitorId(): string
    {
        return bin2hex(random_bytes(self::VISITOR_ID_BYTES));
    }
}
