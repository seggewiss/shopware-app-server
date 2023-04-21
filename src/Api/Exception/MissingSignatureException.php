<?php

declare(strict_types=1);

namespace App\Api\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MissingSignatureException extends HttpException
{
    public function __construct()
    {
        parent::__construct(
            Response::HTTP_FORBIDDEN,
            'Missing signature in Request.'
        );
    }
}
