<?php

namespace ShoppingCart\Tests\Product\Infrastructure\Controller;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Product\Domain\ProductCollection;
use ShoppingCart\Tests\Product\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class ProductsFinderControllerTest extends AcceptanceTestCase
{
    public function testGetAllProducts(): void
    {
        $this->json('GET', '/products');
        $this->asserStatusCode(200);
        $this->asserResponseContent([]);
    }
    public function testGetAProduct(): void
    {
        $expectedProduct = ProductObjectMother::make();
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($expectedProduct);
        $em->flush();

        $this->json('GET', '/products');
        $this->asserStatusCode(200);
        $this->asserResponseContent([
            [
                'id' => $expectedProduct->id,
                'title' => $expectedProduct->title,
                'description' => $expectedProduct->description,
                'photo' => $expectedProduct->photo,
                'price' => $expectedProduct->price,
            ]
        ]);
    }
    public function testGetTwoProducts(): void
    {
        $expectedProduct1 = ProductObjectMother::make();
        $expectedProduct2 = ProductObjectMother::make();
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($expectedProduct1);
        $em->persist($expectedProduct2);
        $em->flush();

        $this->json('GET', '/products');
        $this->asserStatusCode(200);
        $this->asserResponseContent([
            [
                'id' => $expectedProduct1->id,
                'title' => $expectedProduct1->title,
                'description' => $expectedProduct1->description,
                'photo' => $expectedProduct1->photo,
                'price' => $expectedProduct1->price,
            ], [
                'id' => $expectedProduct2->id,
                'title' => $expectedProduct2->title,
                'description' => $expectedProduct2->description,
                'photo' => $expectedProduct2->photo,
                'price' => $expectedProduct2->price,
            ]
        ]);
    }
}
