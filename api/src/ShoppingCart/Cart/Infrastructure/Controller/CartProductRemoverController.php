<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Infrastructure\Request\CartProductRemoverRequest;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CartProductRemoverController extends ApiController
{
    public function __invoke(CartProductRemoverRequest $request, string $cartId): JsonResponse
    {
        return new JsonResponse(null, 204);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}