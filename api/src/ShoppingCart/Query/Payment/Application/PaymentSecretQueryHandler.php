<?php

namespace ShoppingCart\Query\Payment\Application;

use ShoppingCart\Query\Payment\Domain\PaymentException;
use ShoppingCart\Query\Payment\Domain\PaymentRepository;
use ShoppingCart\Query\Payment\Domain\PaymentSecretRepository;
use ShoppingCart\Shared\Domain\Bus\QueryHandler;

final readonly class PaymentSecretQueryHandler implements QueryHandler
{
    public function __construct(
        private PaymentRepository $paymentRepository,
        private PaymentSecretRepository $paymentSecretRepository,
    ) {
    }

    public function ask(PaymentSecretQuery $query): PaymentSecretQueryResponse
    {
        $payment = $this->paymentRepository->find($query->id);
        if (!$payment) {
            throw PaymentException::notfound($query->id);
        }

        return new PaymentSecretQueryResponse($payment->secret($this->paymentSecretRepository));
    }
}
