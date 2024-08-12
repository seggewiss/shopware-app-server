<?php declare(strict_types=1);

namespace Segge\AppServer\Framework\Exception;

use Symfony\Component\HttpFoundation\Response;

class EntityPropertyRequiredException extends AppHttpException
{
    public const ERROR_CODE = 'ENTITY_PROPERTY_REQUIRED_EXCEPTION';

    public function __construct(string $message, array $parameters = [])
    {
        parent::__construct(\sprintf('"%s" is required to be set', $message), $parameters, null);
    }

    public function getErrorCode(): string
    {
        return self::ERROR_CODE;
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
