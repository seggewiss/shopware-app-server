<?php

declare(strict_types=1);

namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestLocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 20]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        /**
         * This case is irrelevant, as we simply return here
         *
         * @infection-ignore-all
         */
        if ($request->getMethod() !== Request::METHOD_GET || !$request->query->has('sw-user-language')) {
            return;
        }

        $userLanguage = $request->query->get('sw-user-language');
        if (!\is_string($userLanguage)) {
            return;
        }

        $request->setLocale($userLanguage);
    }
}
