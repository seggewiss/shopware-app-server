<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ShopRepository;
use App\Service\RegistrationService;
use App\Service\RequestVerifier;
use Shopware\AppBundle\Attribute\ConfirmationRoute;
use Shopware\AppBundle\Attribute\RegistrationRoute;
use Shopware\AppBundle\Authentication\ResponseSigner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private RegistrationService $registrationService,
        private ResponseSigner $responseSigner,
        private ShopRepository $shopRepository,
        private RequestVerifier $requestVerifier,
        private string $appSecret
    ) {
    }

    #[RegistrationRoute(
        name: 'register',
        path: '/register'
    )]
    public function register(Request $request): Response
    {
        $confirmUrl = $this->generateUrl('confirm', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $shop = $this->shopRepository->find($request->query->get('shop-id'));

        if ($shop !== null) {
            $this->requestVerifier->authenticateRegistrationRequest($request, $this->appSecret);

            $proof = [
                'proof' => $this->responseSigner->getRegistrationSignature($shop, $this->appSecret),
                'confirmation_url' => $confirmUrl,
                'secret' => $shop->getShopSecret(),
            ];
        } else {
            $proof = $this->registrationService->handleShopRegistrationRequest(
                $request,
                $confirmUrl
            );
        }

        return new JsonResponse($proof, Response::HTTP_OK);
    }

    #[ConfirmationRoute(
        name: 'confirm',
        path: '/confirm'
    )]
    public function confirm(Request $request): Response
    {
        $this->registrationService->handleConfirmation($request);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
