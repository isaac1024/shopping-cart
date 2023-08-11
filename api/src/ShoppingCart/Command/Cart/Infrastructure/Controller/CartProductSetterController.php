<?php

namespace ShoppingCart\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Application\CartProductSetterCommand;
use ShoppingCart\Command\Cart\Domain\CartException;
use ShoppingCart\Command\Cart\Domain\NotFoundCartException;
use ShoppingCart\Command\Cart\Domain\ProductCollectionException;
use ShoppingCart\Command\Cart\Domain\ProductException;
use ShoppingCart\Command\Cart\Infrastructure\Request\CartProductSetterRequest;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CartProductSetterController extends ApiController
{
    public function __invoke(CartProductSetterRequest $request, string $cartId): JsonResponse
    {
        $this->commandBus->dispatch(new CartProductSetterCommand($cartId, $request->productId, $request->quantity));

        return new JsonResponse(null, 204);
    }

    protected function mapExceptions(): array
    {
        return [
            NotFoundCartException::class => 404,
            CartIdException::class => 400,
            CartException::class => 400,
            ProductException::class => 400,
            ProductCollectionException::class => 400,
        ];
    }
}
