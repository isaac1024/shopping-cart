<?php

namespace ShoppingCart\Command\Order\Infrastructure\Controller;

use ShoppingCart\Query\Cart\Application\CartFinderQuery;
use ShoppingCart\Query\Cart\Application\CartFinderResponse;
use ShoppingCart\Command\Order\Application\OrderCreatorCommand;
use ShoppingCart\Command\Order\Domain\AddressException;
use ShoppingCart\Command\Order\Domain\DuplicateProductException;
use ShoppingCart\Command\Order\Domain\NameException;
use ShoppingCart\Command\Order\Domain\NumberItemsException;
use ShoppingCart\Command\Order\Domain\OrderIdException;
use ShoppingCart\Command\Order\Domain\ProductException;
use ShoppingCart\Command\Order\Infrastructure\Request\OrderCreatorRequest;
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
        ];
    }
}
