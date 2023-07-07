<?php

namespace ShoppingCart\Tests\Product\Infrastructure\Controller;

use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class ProductsFinderControllerTest extends AcceptanceTestCase
{
    public function testGetAllProducts(): void
    {
        $this->json('GET', '/products');
        $this->asserStatusCode(200);
    }
}
