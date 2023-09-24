<?php

namespace ShoppingCart\Tests\Query\Cart\Infrastructure\Controller;

use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\Cart\Domain\ProductCollectionOrderMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartFinderControllerTest extends AcceptanceTestCase
{
    public function testGetACart(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollectionOrderMother::make(2);
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('GET', sprintf("/carts/%s", $cartId->value));
        self::assertResponseStatusCodeSame(200);

        $expected = [
            'id' => $cartId->value,
            'numberItems' => $productCollection->totalQuantity(),
            'totalAmount' => $productCollection->totalAmount(),
            'productItems' => $productCollection->toArray(),
        ];
        self::assertEquals($expected, $this->response());
    }
    public function testNotFoundACart(): void
    {
        $this->json('GET', sprintf("/carts/%s", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
