<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Controller;

use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateNewCart(): void
    {
        $this->json('POST', '/carts');
        self::assertResponseStatusCodeSame(201);
    }
}
