<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

use Psr\Http\Message\ServerRequestInterface;

interface ActionFactoryInterface
{
    public function createAction(): ActionInterface;

    public function createActionFromRequest(ServerRequestInterface $serverRequest): ActionInterface;
}
