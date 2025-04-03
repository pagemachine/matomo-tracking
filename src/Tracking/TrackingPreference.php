<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

use Psr\Http\Message\ServerRequestInterface;

final class TrackingPreference
{
    public function __construct(
        public readonly bool $isAllowed,
        public readonly string $reason,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        if (!empty($request->getHeaderLine('DNT'))) {
            return new self(false, 'DNT (Do Not Track) detected');
        }

        if (!empty($request->getHeaderLine('Sec-GPC'))) {
            return new self(false, 'Sec-GPC (Global Privacy Control) detected');
        }

        return new self(true, 'none');
    }
}
