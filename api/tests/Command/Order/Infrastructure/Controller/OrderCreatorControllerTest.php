<?php

namespace ShoppingCart\Tests\Command\Order\Infrastructure\Controller;

use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Command\Order\Infrastructure\Request\OrderCreatorRequestObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class OrderCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateOrder(): void
    {
        $cartId = CartIdObjectMother::make();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
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

        $request = OrderCreatorRequestObjectMother::make(cartId: $cartId->value);

        $this->json('POST', '/orders', $request);
        self::assertResponseStatusCodeSame(201);
    }
}
