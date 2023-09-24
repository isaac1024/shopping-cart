<?php

namespace Query\Payment\Infrastructure\Controller;

use Faker\Factory;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class PaymentSecretControllerTest extends AcceptanceTestCase
{
    public function testGetAPaymentSecret(): void
    {
        $faker = Factory::create();
        $now = DateTimeUtils::now();
        $paymentId = UuidUtils::random();
        $this->prepareRecord('orders', [
            'id' => $paymentId,
            'cart_id' => CartIdObjectMother::make()->value,
            'status' => 'pending_payment',
            'address' => $faker->address,
            'name' => $faker->name,
            'number_items' => 2,
            'total_amount' => 10,
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

        $this->json('GET', sprintf("/payments/%s", $paymentId));
        self::assertResponseStatusCodeSame(200);
    }
    public function testNotFoundAPayment(): void
    {
        $this->json('GET', sprintf("/payments/%s", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
