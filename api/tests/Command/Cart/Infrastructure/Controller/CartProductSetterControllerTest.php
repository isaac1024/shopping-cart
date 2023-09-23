<?php

namespace ShoppingCart\Tests\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductSetterControllerTest extends AcceptanceTestCase
{
    public function testUpdateProductQuantity(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->assertHasDatabase('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity() + 3,
        ]);
    }

    public function testCartNotFound(): void
    {
        $this->json('POST', "/carts/21e95684-4279-4dc0-82fc-b8420e4fe39f/product_quantity", [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 4
        ]);
        self::assertResponseStatusCodeSame(404);
    }

    public function testProductNotFound(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => '9eb7ac85-1020-44f5-bbfd-43f23b542011',
            'quantity' => 4
        ]);
        self::assertResponseStatusCodeSame(400);
    }

    public function testUpdateProductQuantityToZero(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 0
        ]);
        self::assertResponseStatusCodeSame(400);
    }

    public function testUpdateProductQuantityToNegative(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => -1
        ]);
        self::assertResponseStatusCodeSame(400);
    }
    public function testUpdateTwoProductsQuantity(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cartId->value), [
            'productId' => '0dc19bc6-2520-430b-9ed6-b1dc6bcfe01e',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->assertHasDatabase('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity() + 6,
        ]);
    }
}
