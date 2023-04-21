<?php

declare(strict_types=1);

namespace App\Api\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class SignatureAuthenticated
{
}
