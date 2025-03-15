<?php

namespace App\Http\Exceptions;

use Exception;
use App\Http\Controllers\V1\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception
{
    use ApiResponseTrait;

    use ApiResponseTrait;

    public function __construct($message = "Authentication required")
    {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED);
    }

    public function render($request): JsonResponse
    {
        return $this->errorResponse(
            'Authentication required',
            $this->getMessage(),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
