<?php

namespace Query\Payment\Infrastructure\Controller;

use ShoppingCart\Command\Order\Domain\OrderRepository;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Order\Domain\OrderObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class PaymentSecretControllerTest extends AcceptanceTestCase
{
    public function testGetAPaymentSecret(): void
    {
        $order = OrderObjectMother::make();
        $this->getRepository(OrderRepository::class)->save($order);

        $this->json('GET', sprintf("/payments/%s", $order->orderId()));
        self::assertResponseStatusCodeSame(200);
    }
    public function testNotFoundAPayment(): void
    {
        $this->json('GET', sprintf("/payments/%s", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
