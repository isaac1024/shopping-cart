<?php

namespace ShoppingCart\Query\Product\Infrastructure\Controller;

use ShoppingCart\Query\Product\Application\ProductsFinderQuery;
use ShoppingCart\Query\Product\Application\ProductsFinderQueryResponse;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class ProductsFinderController extends ApiController
{
    public function __invoke(): JsonResponse
    {
        /** @var ProductsFinderQueryResponse $productsResponse */
        $productsResponse = $this->queryBus->ask(new ProductsFinderQuery());
        return  new JsonResponse($productsResponse->products, Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}
