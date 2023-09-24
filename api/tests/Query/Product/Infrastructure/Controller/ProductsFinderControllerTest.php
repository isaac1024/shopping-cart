<?php

namespace ShoppingCart\Tests\Query\Product\Infrastructure\Controller;

use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class ProductsFinderControllerTest extends AcceptanceTestCase
{
    public function testGetAllProducts(): void
    {
        $this->json('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->response();
        self::assertCount(7, $response);
    }
}
