<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShopEntity;
use GuzzleHttp\Psr7\Uri;
use Shopware\AppBundle\Authentication\RequestVerifier as AppTemplateRequestVerifier;
use Shopware\AppBundle\Exception\SignatureValidationException;
use Shopware\AppBundle\Shop\ShopInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @codeCoverageIgnore this is only an extension which converts symfony requests beforehand
 */
class RequestVerifier
{
    public function __construct(
        private HttpMessageFactoryInterface $httpMessageFactory,
        private AppTemplateRequestVerifier $requestVerifier
    ) {
    }

    public function authenticatePostRequest(Request $request, ShopEntity $shop): void
    {
        $this->requestVerifier->authenticatePostRequest(
            $this->httpMessageFactory->createRequest($request),
            $shop
        );
    }

    public function authenticateGetRequest(Request $request, ShopEntity $shop): void
    {
        $this->requestVerifier->authenticateGetRequest(
            $this->httpMessageFactory->createRequest($request),
            $shop
        );
    }

    public function authenticateRegistrationRequest(Request $request, string $appSecret): void
    {
        $this->requestVerifier->authenticateRegistrationRequest(
            $this->httpMessageFactory->createRequest($request),
            $appSecret
        );
    }

    /**
     * Shopware sends the admin extension sdk request weirdly encoded
     * So we need to convert the query string before we can verify the signature
     */
    public function authenticateAdminSdkRequest(Request $request, ShopInterface $shop): void
    {
        if (!$request->query->has('shopware-shop-signature')) {
            throw new SignatureValidationException($this->httpMessageFactory->createRequest($request));
        }

        $originalSignature = $request->query->get('shopware-shop-signature');

        if (!$originalSignature) {
            throw new SignatureValidationException($this->httpMessageFactory->createRequest($request));
        }

        $request->query->remove('shopware-shop-signature');

        /** @var array<string, string|null> $params */
        $params = $request->query->all();

        if ($request->query->has('privileges')) {
            // Somehow, the json characters ",:" will not be properly encoded by Uri->getQuery()
            // this would lead to a different signature than the one provided by Shopware
            $params['privileges'] = \rawurlencode($request->query->get('privileges'));
        }

        $uri = Uri::withQueryValues(
            new Uri(),
            $params
        );

        $signature = \hash_hmac(
            'sha256',
            $uri->getQuery(),
            $shop->getShopSecret()
        );

        if ($originalSignature !== $signature) {
            throw new SignatureValidationException($this->httpMessageFactory->createRequest($request));
        }
    }
}
