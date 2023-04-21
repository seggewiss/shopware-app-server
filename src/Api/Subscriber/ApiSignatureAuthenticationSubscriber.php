<?php

declare(strict_types=1);

namespace App\Api\Subscriber;

use App\Api\Attribute\SignatureAuthenticated;
use App\Api\Exception\MissingSignatureException;
use App\Repository\ShopRepository;
use App\Service\RequestVerifier;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiSignatureAuthenticationSubscriber implements EventSubscriberInterface
{
    private const QUERY_SHOPWARE_SHOP_SIGNATURE = 'shopware-shop-signature';
    private const QUERY_SHOPWARE_SHOP_ID = 'shop-id';

    public function __construct(
        private RequestVerifier $requestVerifier,
        private ShopRepository $shopRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if (!$event->isMainRequest() || $event->isPropagationStopped()) {
            return;
        }

        if (!$event->getRequest()->attributes->has('_controller')) {
            return;
        }

        $classString = $event->getRequest()->attributes->get('_controller');
        [$controller, $method] = \explode('::', $classString);

        if (!\class_exists($controller)) {
            return;
        }

        $ref = new \ReflectionClass($controller);
        $attr = $ref->getAttributes(SignatureAuthenticated::class);

        if (!$attr) {
            if (!$ref->hasMethod($method)) {
                return; // @codeCoverageIgnore
            }

            $method = $ref->getMethod($method);

            $attr = $method->getAttributes(SignatureAuthenticated::class);

            if (!$attr) {
                return; // @codeCoverageIgnore
            }
        }

        $request = $event->getRequest();

        if (!$request->query->has(self::QUERY_SHOPWARE_SHOP_SIGNATURE)) {
            throw new MissingSignatureException();
        }

        if (!$request->query->has(self::QUERY_SHOPWARE_SHOP_ID)) {
            throw new BadRequestException('shop-id missing in request');
        }

        $shopId = $request->query->get(self::QUERY_SHOPWARE_SHOP_ID);
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException(
                \sprintf('shop with id %s not found', $shopId)
            );
        }

        $this->requestVerifier->authenticateAdminSdkRequest($request, $shop);
    }
}
