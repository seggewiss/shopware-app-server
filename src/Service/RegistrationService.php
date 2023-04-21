<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShopEntity;
use Doctrine\ORM\EntityManagerInterface;
use Shopware\AppBundle\Authentication\ResponseSigner;
use Shopware\AppBundle\Registration\ShopSecretGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationService
{
    public function __construct(
        private string $appSecret,
        private EntityManagerInterface $entityManager,
        private RequestVerifier $requestVerifier,
        private ResponseSigner $responseSigner,
        private ShopSecretGeneratorInterface $shopSecretGeneratorInterface
    ) {
    }

    /**
     * @return string[]
     */
    public function handleShopRegistrationRequest(Request $request, string $confirmUrl): array
    {
        $this->requestVerifier->authenticateRegistrationRequest($request, $this->appSecret);
        $shopUrl = $request->query->get('shop-url');
        if (!\is_string($shopUrl)) {
            $shopUrl = '';
        }

        $shopId = $request->query->get('shop-id');
        if (!\is_string($shopId)) {
            $shopId = '';
        }

        $shop = (new ShopEntity())
            ->setId($shopId)
            ->setShopUrl($shopUrl)
            ->setShopSecret($this->shopSecretGeneratorInterface->generate());

        $this->entityManager->persist($shop);
        $this->entityManager->flush();

        return [
            'proof' => $this->responseSigner->getRegistrationSignature($shop, $this->appSecret),
            'confirmation_url' => $confirmUrl,
            'secret' => $shop->getShopSecret(),
        ];
    }

    public function handleConfirmation(Request $request): void
    {
        /** @var string $content */
        $content = $request->getContent();
        $requestContent = \json_decode($content, true);
        if (!\is_array($requestContent)) {
            return;
        }

        /** @var ShopEntity|null $shop */
        $shop = $this->entityManager->getRepository(ShopEntity::class)->find($requestContent['shopId']);
        if ($shop === null) {
            return;
        }

        $this->requestVerifier->authenticatePostRequest($request, $shop);

        if (\array_key_exists('apiKey', $requestContent)) {
            $shop->setApiKey($requestContent['apiKey']);
        }

        if (\array_key_exists('secretKey', $requestContent)) {
            $shop->setSecretKey($requestContent['secretKey']);
        }

        $this->entityManager->persist($shop);
        $this->entityManager->flush();
    }
}
