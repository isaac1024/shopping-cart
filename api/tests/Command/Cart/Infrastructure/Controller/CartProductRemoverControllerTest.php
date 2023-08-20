<?php

namespace ShoppingCart\Tests\Command\Cart\Infrastructure\Controller;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\AcceptanceTestCase;

class CartProductRemoverControllerTest extends AcceptanceTestCase
{
    public function testRemoveProductFromCart(): void
    {
        $prductId = '307028d4-8a2f-4441-a3ac-0c904c12bf86';
        $prduct = ProductObjectMother::make($prductId);
        $cart = CartObjectMother::make(productCollection: new ProductCollection($prduct));

        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_delete", $cart->cartId()), [
            'productId' => $prductId,
        ]);
        self::assertResponseStatusCodeSame(204);
    }

    public function testRemoveProductFromCartNotExistOnCollection(): void
    {
        $prductId = '307028d4-8a2f-4441-a3ac-0c904c12bf86';
        $otherProductId = 'b473ca32-d86a-4ec6-83cb-1747a372a300';
        $prduct = ProductObjectMother::make($prductId);
        $cart = CartObjectMother::make(productCollection: new ProductCollection($prduct));

        $cartRepository = $this->getRepository(CartRepository::class);
        $cartRepository->save($cart);

        $this->json('POST', sprintf("/carts/%s/product_delete", $cart->cartId()), [
            'productId' => $otherProductId,
        ]);
        self::assertResponseStatusCodeSame(204);
    }

    public function testCartNotFound(): void
    {
        $this->json('POST', "/carts/3e0d6b12-14ac-4a64-b67f-a11fb713bb90/product_delete", [
            'productId' => 'dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31',
        ]);
        self::assertResponseStatusCodeSame(404);
    }
}