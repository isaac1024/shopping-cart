<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Infrastructure\Controller;

use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class NumberItemsCartFinderControllerTest extends AcceptanceTestCase
{
    public function testGetACart(): void
    {
        $cartId = CartIdObjectMother::make();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => 0,
            'total_amount' => 0,
            'product_items' => json_encode([]),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('GET', sprintf("/carts/%s/items", $cartId->value));
        self::assertResponseStatusCodeSame(200);
    }
    public function testNotFoundACart(): void
    {
        $this->json('GET', sprintf("/carts/%s/items", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
