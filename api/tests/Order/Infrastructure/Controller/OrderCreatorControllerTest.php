<?php

namespace ShoppingCart\Tests\Order\Infrastructure\Controller;

use Faker\Factory;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Order\Domain\OrderPendingToPay;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Cart\Domain\ProductCollectionOrderMother;
use ShoppingCart\Tests\Order\Domain\OrderPendingToPayObjectMother;
use ShoppingCart\Tests\Order\Infrastructure\Request\CartCreatorRequestObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class OrderCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateOrder(): void
    {
        $faker = Factory::create();
        $cart = CartObjectMother::make(productCollection: ProductCollectionOrderMother::make($faker->numberBetween(1, 5)));
        $this->getRepository(CartRepository::class)->save($cart);

        $request = CartCreatorRequestObjectMother::make(cartId: $cart->getCartId());

        $this->json('POST', '/orders', $request);
        self::assertResponseStatusCodeSame(201);

        $this->assertSendEvent(OrderPendingToPay::class);
    }
}
