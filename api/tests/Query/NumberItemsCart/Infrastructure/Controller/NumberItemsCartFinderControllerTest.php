<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class NumberItemsCartFinderControllerTest extends AcceptanceTestCase
{
    public function testGetACart(): void
    {
        $cart = CartObjectMother::make();
        $this->getRepository(CartRepository::class)->save($cart);

        $this->json('GET', sprintf("/carts/%s/items", $cart->cartId()));
        self::assertResponseStatusCodeSame(200);
    }
    public function testNotFoundACart(): void
    {
        $this->json('GET', sprintf("/carts/%s/items", UuidUtils::random()));
        self::assertResponseStatusCodeSame(404);
    }
}
