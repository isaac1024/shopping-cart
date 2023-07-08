<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Controller;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartFinderControllerTest extends AcceptanceTestCase
{
    public function testGetACart()
    {
        $cart = CartObjectMother::make();
        $this->getRepository(CartRepository::class)->save($cart);

        $this->json('GET', sprintf("/carts/%s", $cart->getCartId()));
        self::assertResponseStatusCodeSame(200);
    }
    public function testNotFoundACart()
    {
        $this->json('GET', sprintf("/carts/%s", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
