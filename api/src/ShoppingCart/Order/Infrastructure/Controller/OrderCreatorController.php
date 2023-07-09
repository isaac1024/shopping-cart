<?php

namespace ShoppingCart\Order\Infrastructure\Controller;

use ShoppingCart\Cart\Application\CartFinderQuery;
use ShoppingCart\Cart\Application\CartFinderResponse;
use ShoppingCart\Order\Application\OrderCreatorCommand;
use ShoppingCart\Order\Domain\AddressException;
use ShoppingCart\Order\Domain\DuplicateProductException;
use ShoppingCart\Order\Domain\NameException;
use ShoppingCart\Order\Domain\NumberItemsException;
use ShoppingCart\Order\Domain\OrderIdException;
use ShoppingCart\Order\Domain\ProductException;
use ShoppingCart\Order\Domain\TotalAmountException;
use ShoppingCart\Order\Infrastructure\Request\OrderCreatorRequest;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final readonly class OrderCreatorController extends ApiController
{
    public function __invoke(OrderCreatorRequest $request): JsonResponse
    {
        $id = UuidUtils::random();

        /** @var CartFinderResponse $cart */
        $cart = $this->queryBus->ask(new CartFinderQuery($request->cartId));

        $this->commandBus->dispatch(new OrderCreatorCommand(
            $id,
            $request->name,
            $request->address,
            $cart->id,
            $cart->productItems,
            $request->card->number,
            $request->card->validDate,
            $request->card->cvv,
        ));

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }

    protected function mapExceptions(): array
    {
        return [
            AddressException::class => 400,
            DuplicateProductException::class => 500,
            NameException::class => 400,
            NumberItemsException::class => 400,
            OrderIdException::class => 500,
            CartIdException::class => 400,
            ProductException::class => 500,
            TotalAmountException::class => 400,
        ];
    }
}
