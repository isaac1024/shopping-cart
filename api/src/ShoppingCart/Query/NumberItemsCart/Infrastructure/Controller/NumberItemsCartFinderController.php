<?php

namespace ShoppingCart\Query\NumberItemsCart\Infrastructure\Controller;

use ShoppingCart\Query\NumberItemsCart\Application\NumberItemsCartFinderQuery;
use ShoppingCart\Query\NumberItemsCart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class NumberItemsCartFinderController extends ApiController
{
    public function __invoke(string $cartId): JsonResponse
    {
        $cartResponse = $this->queryBus->ask(new NumberItemsCartFinderQuery($cartId));

        return new JsonResponse($cartResponse, Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [
            NotFoundCartException::class => 404,
        ];
    }
}
