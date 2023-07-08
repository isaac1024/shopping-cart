<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Cart\Infrastructure\Request\CartProductSetterRequest;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CartProductSetterController extends ApiController
{
    public function __invoke(CartProductSetterRequest $request, string $cartId): JsonResponse
    {
        return new JsonResponse(null, 204);
    }

    protected function mapExceptions(): array
    {
        return [
            NotFoundCartException::class => 404,
        ];
    }
}
