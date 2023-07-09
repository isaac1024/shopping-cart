<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Application\CartProductSetterCommand;
use ShoppingCart\Cart\Domain\CartException;
use ShoppingCart\Cart\Domain\DuplicateProductException;
use ShoppingCart\Cart\Domain\NegativeProductPriceException;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Cart\Domain\NumberItemsException;
use ShoppingCart\Cart\Domain\ProductCollectionException;
use ShoppingCart\Cart\Domain\ProductException;
use ShoppingCart\Cart\Domain\TotalAmountException;
use ShoppingCart\Cart\Infrastructure\Request\CartProductSetterRequest;
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
            NumberItemsException::class => 400,
            TotalAmountException::class => 400,
            ProductException::class => 400,
            ProductCollectionException::class => 400,
            DuplicateProductException::class => 500,
            NegativeProductPriceException::class => 500,
        ];
    }
}
