<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Entity\ShopEntity;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShopEntityResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private ShopRepository $shopRepository
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if ($argument->getType() !== ShopEntity::class) {
            return false;
        }

        if (!$request->query->has('shop-id')) {
            return false;
        }

        return true;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $shopId = $request->query->get('shop-id');

        if (!\is_string($shopId)) {
            throw new BadRequestHttpException('shop-id should be a string');
        }

        $shopId = \strtok($shopId, '?');

        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException(
                \sprintf('shop with id %s not found', $shopId)
            );
        }

        yield $shop;
    }
}
