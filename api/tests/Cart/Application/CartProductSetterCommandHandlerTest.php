<?php

namespace ShoppingCart\Tests\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Cart\Application\CartProductSetterCommandHandler;
use ShoppingCart\Cart\Domain\CartException;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Cart\Domain\ProductCollection;
use ShoppingCart\Cart\Domain\ProductCollectionException;
use ShoppingCart\Cart\Domain\ProductException;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartProductSetterCommandHandlerTest extends UnitTestCase
{
    private CartRepository&MockObject $cartRepository;
    private CartProductSetterCommandHandler $cartProductSetterCommandHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->cartProductSetterCommandHandler = new CartProductSetterCommandHandler($this->cartRepository);
    }

    public function testAddNewProduct(): void
    {
        $cart = CartObjectMother::make();
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make($cart->getCartId(), $product->productId);

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('findProduct')
            ->with($command->productId)
            ->willReturn($product);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testUpdateProduct(): void
    {
        $product = ProductObjectMother::make();
        $cart = CartObjectMother::make(productCollection: new ProductCollection($product));
        $numberItems = $cart->getNumberItems();
        $totalAmount = $cart->getTotalAmount();
        $command = CartProductSetterCommandObjectMother::make($cart->getCartId(), $product->productId, $product->quantity + 1);

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->never())
            ->method('findProduct');

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cart);

        $this->cartProductSetterCommandHandler->dispatch($command);

        self::assertNotEquals($numberItems, $cart->getNumberItems());
        self::assertNotEquals($totalAmount, $cart->getTotalAmount());
    }

    public function testProductNotExist(): void
    {
        $cart = CartObjectMother::make();
        $command = CartProductSetterCommandObjectMother::make($cart->getCartId());

        $this->expectException(CartException::class);
        $this->expectExceptionMessage(sprintf("Not exist a product with id '%s'", $command->productId));

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('findProduct')
            ->with($command->productId)
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testAddProductWithZeroQuantity(): void
    {
        $cart = CartObjectMother::make();
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make($cart->getCartId(), $product->productId, 0);

        $this->expectException(ProductCollectionException::class);
        $this->expectExceptionMessage("Can't add a product with 0 quantity");

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('findProduct')
            ->with($command->productId)
            ->willReturn($product);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testAddProductWithNegativeQuantity(): void
    {
        $cart = CartObjectMother::make();
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make($cart->getCartId(), $product->productId, -1);

        $this->expectException(ProductException::class);
        $this->expectExceptionMessage("Product cart quantity can't be negative");

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('findProduct')
            ->with($command->productId)
            ->willReturn($product);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testNotFoundCart(): void
    {
        $command = CartProductSetterCommandObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $command->cartId));

        $this->cartRepository->expects($this->once())
            ->method('find')
            ->with(new CartId($command->cartId))
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }
}
