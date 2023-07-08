<?php

namespace ShoppingCart\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Application\CartCreatorCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class CartCreatorController extends ApiController
{
    public function __invoke(): JsonResponse
    {
        $id = UuidUtils::random();
        $this->commandBus->dispatch(new CartCreatorCommand($id));

        return  new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}
