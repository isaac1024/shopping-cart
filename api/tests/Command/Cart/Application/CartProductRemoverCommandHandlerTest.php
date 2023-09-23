<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartProductRemoverCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartModel;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
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
        $now = DateTimeUtils::now();
        $product = ProductObjectMother::make();
        $command = CartProductRemoverCommandObjectMother::make(productId: $product->productId);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, new ProductCollection($product));
        $cartModel = new CartModel(
            $command->cartId,
            0,
            0,
            [],
            $now,
            $now
        );

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
        $now = DateTimeUtils::now();
        $product = ProductObjectMother::make();
        $productCollection = new ProductCollection($product);
        $command = CartProductRemoverCommandObjectMother::make(productId: UuidUtils::random());
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);
        $cartModel = new CartModel(
            $command->cartId,
            $productCollection->totalQuantity(),
            $productCollection->totalAmount(),
            $productCollection->toArray(),
            $now,
            $now
        );

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
