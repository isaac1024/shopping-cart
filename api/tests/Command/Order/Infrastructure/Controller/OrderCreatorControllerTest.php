<?php

namespace ShoppingCart\Tests\Command\Order\Infrastructure\Controller;

use Faker\Factory;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Payment\OrderPendingToPay;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductCollectionOrderMother;
use ShoppingCart\Tests\Command\Order\Infrastructure\Request\OrderCreatorRequestObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class OrderCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateOrder(): void
    {
        $faker = Factory::create();
        $cart = CartObjectMother::make(productCollection: ProductCollectionOrderMother::make($faker->numberBetween(1, 5)));
        $this->getRepository(CartRepository::class)->save($cart);

        $request = OrderCreatorRequestObjectMother::make(cartId: $cart->cartId());

        $this->json('POST', '/orders', $request);
        self::assertResponseStatusCodeSame(201);

        $this->assertSendEvents(['shopping_cart.order.pending_to_pay']);
    }
}
