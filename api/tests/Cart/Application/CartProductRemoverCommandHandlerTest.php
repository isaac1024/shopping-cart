<?php

namespace ShoppingCart\Tests\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Cart\Application\CartProductRemoverCommandHandler;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Cart\Domain\ProductObjectMother;
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
        $cart = CartObjectMother::make(productCollection: new ProductCollection($product));
        $command = CartProductRemoverCommandObjectMother::make($cart->getCartId(), $product->productId);

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductRemoverCommandHandler->dispatch($command);
        self::assertEquals(0, $cart->getNumberItems());
        self::assertEquals(0, $cart->getTotalAmount());
    }

    public function testRemoveAProductThatNotExistOnCart(): void
    {
        $product = ProductObjectMother::make();
        $cart = CartObjectMother::make(productCollection: new ProductCollection($product));
        $command = CartProductRemoverCommandObjectMother::make($cart->getCartId(), UuidUtils::random());
        $cartNumberItems = $cart->getNumberItems();
        $cartTotalAmount = $cart->getTotalAmount();

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductRemoverCommandHandler->dispatch($command);
        self::assertEquals($cartNumberItems, $cart->getNumberItems());
        self::assertEquals($cartTotalAmount, $cart->getTotalAmount());
    }

    public function testNotFoundCart(): void
    {
        $command = CartProductRemoverCommandObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $command->cartId));

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }
}
