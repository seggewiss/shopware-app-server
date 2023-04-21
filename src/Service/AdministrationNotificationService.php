<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShopEntity;
use Shopware\AppBundle\Client\ClientFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdministrationNotificationService
{
    public const NOTIFICATION_STATUS_SUCCESS = 'success';
    public const NOTIFICATION_STATUS_INFO = 'info';
    public const NOTIFICATION_STATUS_WARNING = 'warning';
    public const NOTIFICATION_STATUS_ERROR = 'error';

    private const NOTIFICATION_CREATE_ENDPOINT = '/api/notification';

    public function __construct(
        private ClientFactoryInterface $clientFactory,
        private HttpMessageFactoryInterface $requestFactory
    ) {
    }

    public function createNotification(
        string $message,
        ShopEntity $shopEntity,
        string $status = self::NOTIFICATION_STATUS_INFO
    ): void {
        $client = $this->clientFactory->createClient($shopEntity);
        $body = [
            'message' => $message,
            'status' => $status,
        ];
        $body = \json_encode($body);
        if (!\is_string($body)) {
            return;
        }

        $request = Request::create(
            \sprintf('%s%s', $shopEntity->getShopUrl(), self::NOTIFICATION_CREATE_ENDPOINT),
            Request::METHOD_POST,
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            $body
        );

        $response = $client->sendRequest($this->requestFactory->createRequest($request));
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new HttpException($response->getStatusCode(), $response->getReasonPhrase());
        }
    }
}
