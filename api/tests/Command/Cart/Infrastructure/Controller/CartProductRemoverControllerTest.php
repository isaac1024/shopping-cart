<?php

namespace ShoppingCart\Tests\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Command\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductRemoverControllerTest extends AcceptanceTestCase
{
    public function testRemoveProductFromCart(): void
    {
        $prductId = '307028d4-8a2f-4441-a3ac-0c904c12bf86';
        $prduct = ProductObjectMother::make($prductId);
        $cartId = CartIdObjectMother::make();
        $productCollection = new ProductCollection($prduct);
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_delete", $cartId->value), [
            'productId' => $prductId,
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->assertHasDatabase('carts', [
            'id' => $cartId->value,
            'number_items' => 0,
        ]);

        $this->assertSendEvents(['shopping_cart.v1.cart.updated']);
    }

    public function testRemoveProductFromCartNotExistOnCollection(): void
    {
        $prductId = '307028d4-8a2f-4441-a3ac-0c904c12bf86';
        $otherProductId = 'b473ca32-d86a-4ec6-83cb-1747a372a300';
        $prduct = ProductObjectMother::make($prductId);
        $cartId = CartIdObjectMother::make();
        $productCollection = new ProductCollection($prduct);
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $this->json('POST', sprintf("/carts/%s/product_delete", $cartId->value), [
            'productId' => $otherProductId,
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->assertHasDatabase('carts', [
            'id' => $cartId->value,
            'number_items' => $prduct->quantity,
        ]);

        $this->assertSendEvents(['shopping_cart.v1.cart.updated']);
    }

    public function testCartNotFound(): void
    {
        $this->json('POST', "/carts/3e0d6b12-14ac-4a64-b67f-a11fb713bb90/product_delete", [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
        ]);
        self::assertResponseStatusCodeSame(404);
    }
}
