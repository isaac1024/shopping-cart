<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class CartFinderController extends ApiController
{
    public function __invoke(string $cartId): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}