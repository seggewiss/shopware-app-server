<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShopEntity;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestExtractorService
{
    public function __construct(
        private ShopRepository $shopRepository
    ) {
    }

    /**
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function getShopFromRequest(Request $request): ShopEntity
    {
        if (!$request->query->has('shop-id')) {
            throw new BadRequestHttpException('\'shop-id\' not present in Request');
        }

        $shopId = $request->query->getAlnum('shop-id');
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException(
                \sprintf('shop with id %s not found', $shopId)
            );
        }

        return $shop;
    }
}
