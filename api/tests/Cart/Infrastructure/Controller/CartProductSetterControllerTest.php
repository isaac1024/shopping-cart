<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductSetterControllerTest extends AcceptanceTestCase
{
    public function testUpdateProductQuantity(): void
    {
        $cart = CartObjectMother::make();
        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);
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
        $cart = CartObjectMother::make();
        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => '9eb7ac85-1020-44f5-bbfd-43f23b542011',
            'quantity' => 4
        ]);
        self::assertResponseStatusCodeSame(400);
    }

    public function testUpdateProductQuantityToZero(): void
    {
        $cart = CartObjectMother::make();
        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 0
        ]);
        self::assertResponseStatusCodeSame(400);
    }

    public function testUpdateProductQuantityToNegative(): void
    {
        $cart = CartObjectMother::make();
        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => -1
        ]);
        self::assertResponseStatusCodeSame(400);
    }
    public function testUpdateTwoProductsQuantity(): void
    {
        $cart = CartObjectMother::make();
        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);

        $this->json('POST', sprintf("/carts/%s/product_quantity", $cart->getCartId()), [
            'productId' => '0dc19bc6-2520-430b-9ed6-b1dc6bcfe01e',
            'quantity' => 3
        ]);
        self::assertResponseStatusCodeSame(204);
    }
}
