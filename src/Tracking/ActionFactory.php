<?php

declare(strict_types=1);

namespace Pagemachine\MatomoTracking\Tracking;

use Pagemachine\MatomoTracking\Tracking\Attributes\Language;
use Pagemachine\MatomoTracking\Tracking\Attributes\ReferrerUrl;
use Pagemachine\MatomoTracking\Tracking\Attributes\Url;
use Pagemachine\MatomoTracking\Tracking\Attributes\UserAgent;
use Pagemachine\MatomoTracking\Tracking\Attributes\VisitorId;
use Psr\Http\Message\ServerRequestInterface;

final class ActionFactory implements ActionFactoryInterface
{
    public function createAction(): ActionInterface
    {
        $action = (new Action())
            ->withAttribute(new VisitorId());

        return $action;
    }

    public function createActionFromRequest(ServerRequestInterface $serverRequest): ActionInterface
    {
        $action = $this->createAction()
            ->withAttribute(new UserAgent($serverRequest->getHeaderLine('user-agent')))
            ->withAttribute(new Language($serverRequest->getHeaderLine('accept-language')))
            ->withAttribute(new Url((string)$serverRequest->getUri()))
            ->withAttribute(new ReferrerUrl($serverRequest->getServerParams()['HTTP_REFERER'] ?? ''));

        foreach ($serverRequest->getAttribute('matomo.attributes', []) as $attribute) {
            $action = $action->withAttribute($attribute);
        }

        return $action;
    }
}
