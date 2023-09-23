<?php

namespace ShoppingCart\Tests\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartCreatorControllerTest extends AcceptanceTestCase
{
    public function testCreateNewCart(): void
    {
        $this->json('POST', '/carts');
        self::assertResponseStatusCodeSame(201);

        $id = $this->response()['id'] ?? null;
        self::assertIsString($id);
        $this->assertHasDatabase('carts', ['id' => $id]);
    }
}
