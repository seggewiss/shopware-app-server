<?php

declare(strict_types=1);

namespace App\Api\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidSignatureException extends HttpException
{
    public function __construct(string $signature)
    {
        parent::__construct(
            Response::HTTP_FORBIDDEN,
            \sprintf('Could not authenticate with api. Invalid signature: %s', $signature)
        );
    }
}
