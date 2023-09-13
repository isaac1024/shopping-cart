<?php

namespace ShoppingCart\Tests\Query\Payment\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Query\Payment\Domain\PaymentRepository;
use ShoppingCart\Query\Payment\Infrastructure\Repository\DoctrinePaymentRepository;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Order\Domain\OrderObjectMother;
use ShoppingCart\Tests\Query\Payment\Domain\PaymentObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrinePaymentRepositoryTest extends IntegrationTestCase
{
    private PaymentRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrinePaymentRepository::class);
    }

    public function testFindAPayment(): void
    {
        $order = OrderObjectMother::make();

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($order);
        $em->flush();
        $em->clear();

        $expectedPayment = PaymentObjectMother::make($order->orderId(), $order->totalAmount());

        $payment = $this->repository->find($order->orderId());

        self::assertEquals($expectedPayment, $payment);
    }

    public function testNotFindAPayment(): void
    {
        $cart = $this->repository->find(UuidUtils::random());

        self::assertNull($cart);
    }
}
