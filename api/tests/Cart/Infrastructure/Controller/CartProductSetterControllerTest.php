<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductSetterControllerTest extends AcceptanceTestCase
{
    public function testUpdateProductQuantity()
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
}
