<?php

namespace ShoppingCart\Order\Infrastructure\Controller;

use ShoppingCart\Order\Infrastructure\Request\OrderCreatorRequest;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class OrderCreatorController extends ApiController
{
    public function __invoke(OrderCreatorRequest $request): JsonResponse
    {
        $id = UuidUtils::random();

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}