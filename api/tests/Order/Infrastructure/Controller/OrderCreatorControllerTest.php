<?php

namespace ShoppingCart\Tests\Order\Infrastructure\Controller;

use ShoppingCart\Tests\Order\Infrastructure\Request\CartCreatorRequestObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class OrderCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateOrder(): void
    {
        $request = CartCreatorRequestObjectMother::make();
        $this->json('POST', '/orders', $request);
        self::assertResponseStatusCodeSame(201);
    }
}