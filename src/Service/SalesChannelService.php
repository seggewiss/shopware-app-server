<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShopEntity;
use Shopware\AppBundle\Client\ClientFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SalesChannelService
{
    private const SALES_CHANNEL_SEARCH_ENDPOINT = '/api/sales-channel';

    public function __construct(
        private ClientFactoryInterface $clientFactory,
        private HttpMessageFactoryInterface $requestFactory
    ) {
    }

    /**
     * @return string[]
     */
    public function getSalesChannels(ShopEntity $shopEntity): array
    {
        $client = $this->clientFactory->createClient($shopEntity);
        $request = Request::create(
            \sprintf('%s%s', $shopEntity->getShopUrl(), self::SALES_CHANNEL_SEARCH_ENDPOINT),
            Request::METHOD_GET
        );

        $response = $client->sendRequest($this->requestFactory->createRequest($request));
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new HttpException($response->getStatusCode(), $response->getReasonPhrase());
        }

        $responseData = \json_decode($response->getBody()->getContents(), true);
        if (!\is_array($responseData) || !\array_key_exists('data', $responseData)) {
            return [];
        }

        $responseData = $responseData['data'];
        $salesChannels = [];
        foreach ($responseData as $salesChannel) {
            $salesChannels[] = $salesChannel;
        }

        return $salesChannels;
    }
}
