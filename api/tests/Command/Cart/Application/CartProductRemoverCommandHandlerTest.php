<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartProductRemoverCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
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
        $product = ProductObjectMother::make();
        $cart = CartObjectMother::make(productCollection: new ProductCollection($product));
        $command = CartProductRemoverCommandObjectMother::make($cart->cartId(), $product->productId);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductRemoverCommandHandler->dispatch($command);
        self::assertEquals(0, $cart->numberItems());
        self::assertEquals(0, $cart->totalAmount());
    }

    public function testRemoveAProductThatNotExistOnCart(): void
    {
        $product = ProductObjectMother::make();
        $cart = CartObjectMother::make(productCollection: new ProductCollection($product));
        $command = CartProductRemoverCommandObjectMother::make($cart->cartId(), UuidUtils::random());
        $cartNumberItems = $cart->numberItems();
        $cartTotalAmount = $cart->totalAmount();

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductRemoverCommandHandler->dispatch($command);
        self::assertEquals($cartNumberItems, $cart->numberItems());
        self::assertEquals($cartTotalAmount, $cart->totalAmount());
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
