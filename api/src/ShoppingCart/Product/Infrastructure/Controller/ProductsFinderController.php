<?php

namespace ShoppingCart\Product\Infrastructure\Controller;

use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class ProductsFinderController extends ApiController
{
    public function __invoke(): JsonResponse
    {
        return  new JsonResponse([], Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}
