<?php

namespace ShoppingCart\Tests\Query\Payment\Infrastructure\Repository;

use Faker\Factory;
use ShoppingCart\Query\Payment\Domain\PaymentRepository;
use ShoppingCart\Query\Payment\Infrastructure\Repository\DoctrinePaymentRepository;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\Payment\Domain\PaymentObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
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
        $faker = Factory::create();
        $now = DateTimeUtils::now();
        $paymentId = UuidUtils::random();
        $totalAmount = 10;
        $this->prepareRecord('orders', [
            'id' => $paymentId,
            'cart_id' => CartIdObjectMother::make()->value,
            'status' => 'pending_payment',
            'address' => $faker->address,
            'name' => $faker->name,
            'number_items' => 2,
            'total_amount' => $totalAmount,
            'product_items' => json_encode([
                [
                    "productId" => "307028d4-8a2f-4441-a3ac-0c904c12bf86",
                    "title" => "Domain-Driven Design",
                    "photo" => "\/photos\/ddd.jpg",
                    "unitPrice" => 5,
                    "quantity" => 2,
                    "totalPrice" => 10
                ]
            ]),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $expectedPayment = PaymentObjectMother::make($paymentId, $totalAmount);

        $payment = $this->repository->find($paymentId);

        self::assertEquals($expectedPayment, $payment);
    }

    public function testNotFindAPayment(): void
    {
        $cart = $this->repository->find(UuidUtils::random());

        self::assertNull($cart);
    }
}
