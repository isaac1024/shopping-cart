<?php

namespace ShoppingCart\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Application\CartProductRemoverCommand;
use ShoppingCart\Command\Cart\Infrastructure\Request\CartProductRemoverRequest;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
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
