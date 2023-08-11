<?php

namespace ShoppingCart\Query\Cart\Infrastructure\Controller;

use ShoppingCart\Query\Cart\Application\CartFinderQuery;
use ShoppingCart\Query\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class CartFinderController extends ApiController
{
    public function __invoke(string $cartId): JsonResponse
    {
        $cartResponse = $this->queryBus->ask(new CartFinderQuery($cartId));

        return new JsonResponse($cartResponse, Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [
            NotFoundCartException::class => 404,
        ];
    }
}
