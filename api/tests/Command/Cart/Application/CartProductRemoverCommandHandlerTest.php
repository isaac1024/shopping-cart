<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartProductRemoverCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartProductRemoverCommandHandlerTest extends UnitTestCase
{
    private CartRepository&MockObject $cartRepository;
    private CartProductRemoverCommandHandler $cartProductRemoverCommandHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->cartProductRemoverCommandHandler = new CartProductRemoverCommandHandler($this->cartRepository);
    }

    public function testRemoveAProduct(): void
    {
        $product = ProductObjectMother::make();
        $productCollection = new ProductCollection($product);
        $command = CartProductRemoverCommandObjectMother::make(productId: $product->productId);
        $cartModel = CartModelObjectMother::make($command->cartId, ProductCollection::init(), databaseStatus: DatabaseStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with($command->cartId)
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testRemoveAProductFromMany(): void
    {
        $firstProduct = ProductObjectMother::make();
        $secondProduct = ProductObjectMother::make();
        $thirdProduct = ProductObjectMother::make();
        $productCollection = new ProductCollection($firstProduct, $secondProduct, $thirdProduct);
        $command = CartProductRemoverCommandObjectMother::make(productId: $firstProduct->productId);
        $cartModel = CartModelObjectMother::make($command->cartId, new ProductCollection($secondProduct, $thirdProduct), databaseStatus: DatabaseStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with($command->cartId)
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testRemoveAProductThatNotExistOnCart(): void
    {
        $product = ProductObjectMother::make();
        $productCollection = new ProductCollection($product);
        $command = CartProductRemoverCommandObjectMother::make(productId: UuidUtils::random());
        $cartModel = CartModelObjectMother::make($command->cartId, $productCollection, databaseStatus: DatabaseStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testNotFoundCart(): void
    {
        $command = CartProductRemoverCommandObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $command->cartId));

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }
}
