<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Application\CartProductRemoverCommand;
use ShoppingCart\Cart\Domain\CartIdException;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Cart\Infrastructure\Request\CartProductRemoverRequest;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CartProductRemoverController extends ApiController
{
    public function __invoke(CartProductRemoverRequest $request, string $cartId): JsonResponse
    {
        $this->commandBus->dispatch(new CartProductRemoverCommand($cartId, $request->productId));

        return new JsonResponse(null, 204);
    }

    protected function mapExceptions(): array
    {
        return [
            NotFoundCartException::class => 404,
            CartIdException::class => 400,
        ];
    }
}
