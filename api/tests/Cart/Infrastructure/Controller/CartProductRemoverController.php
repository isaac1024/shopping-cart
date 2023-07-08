<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\ProductCollection;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductRemoverController extends AcceptanceTestCase
{
    public function testRemoveProductFromCart(): void
    {
        $prductId = '307028d4-8a2f-4441-a3ac-0c904c12bf86';
        $prduct = ProductObjectMother::make($prductId);
        $cart = CartObjectMother::make(productCollection: new ProductCollection($prduct));

        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_delete", $cart->getCartId()));
        self::assertResponseStatusCodeSame(204);
    }
}