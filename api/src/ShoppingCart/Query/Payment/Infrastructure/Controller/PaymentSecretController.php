<?php

namespace ShoppingCart\Query\Payment\Infrastructure\Controller;

use ShoppingCart\Query\Payment\Application\PaymentSecretQuery;
use ShoppingCart\Query\Payment\Application\PaymentSecretQueryResponse;
use ShoppingCart\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class PaymentSecretController extends ApiController
{
    public function __invoke(string $paymentId): JsonResponse
    {
        /** @var PaymentSecretQueryResponse $paymentSecretQueryResponse */
        $paymentSecretQueryResponse = $this->queryBus->ask(new PaymentSecretQuery($paymentId));
        return  new JsonResponse($paymentSecretQueryResponse, Response::HTTP_OK);
    }

    protected function mapExceptions(): array
    {
        return [];
    }
}
