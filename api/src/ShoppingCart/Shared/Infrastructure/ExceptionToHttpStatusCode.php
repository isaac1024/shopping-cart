<?php

namespace ShoppingCart\Shared\Infrastructure;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExceptionToHttpStatusCode
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    private array $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
    ];

    public function map(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function getStatusCode(string $exceptionClass): int
    {
        return $this->exceptions[$exceptionClass] ?? self::DEFAULT_STATUS_CODE;
    }
}
