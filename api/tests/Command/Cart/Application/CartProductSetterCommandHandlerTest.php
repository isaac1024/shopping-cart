<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartProductSetterCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartException;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Command\Cart\Domain\ProductCollectionException;
use ShoppingCart\Command\Cart\Domain\ProductException;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductObjectMother;
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
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make(productId:  $product->productId);
        $cart = CartObjectMother::fromCartProductSetterCommand($command, ProductCollection::init());
        $productCollection = new ProductCollection($product->addQuantity($command->quantity));
        $cartModel = CartModelObjectMother::make($command->cartId, $productCollection, aggregateStatus: AggregateStatus::UPDATED);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('searchProduct')
            ->with($command->productId)
            ->willReturn($product);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testUpdateProduct(): void
    {
        $product = ProductObjectMother::make();
        $command = CartProductSetterCommandObjectMother::make(productId: $product->productId, quantity: 1);
        $cart = CartObjectMother::fromCartProductSetterCommand($command, new ProductCollection($product));
        $productCollection = new ProductCollection($product->addQuantity($command->quantity));
        $cartModel = CartModelObjectMother::make($command->cartId, $productCollection, aggregateStatus: AggregateStatus::UPDATED);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->never())
            ->method('searchProduct');

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testUpdateProductFromMany(): void
    {
        $firstProduct = ProductObjectMother::make();
        $secondProduct = ProductObjectMother::make();
        $thirdProduct = ProductObjectMother::make();
        $command = CartProductSetterCommandObjectMother::make(productId: $secondProduct->productId, quantity: 1);
        $cart = CartObjectMother::fromCartProductSetterCommand($command, new ProductCollection($firstProduct, $secondProduct, $thirdProduct));
        $productCollection = new ProductCollection($secondProduct->addQuantity(1), $firstProduct, $thirdProduct);
        $cartModel = CartModelObjectMother::make($command->cartId, $productCollection, aggregateStatus: AggregateStatus::UPDATED);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->never())
            ->method('searchProduct');

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testProductNotExist(): void
    {
        $command = CartProductSetterCommandObjectMother::make();
        $cart = CartObjectMother::fromCartProductSetterCommand($command, ProductCollection::init());

        $this->expectException(CartException::class);
        $this->expectExceptionMessage(sprintf("Not exist a product with id '%s'", $command->productId));

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('searchProduct')
            ->with($command->productId)
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testAddProductWithZeroQuantity(): void
    {
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make(productId:  $product->productId, quantity: 0);
        $cart = CartObjectMother::fromCartProductSetterCommand($command, ProductCollection::init());

        $this->expectException(ProductCollectionException::class);
        $this->expectExceptionMessage("Can't add a product with 0 quantity");

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('searchProduct')
            ->with($command->productId)
            ->willReturn($product);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }

    public function testAddProductWithNegativeQuantity(): void
    {
        $product = ProductObjectMother::make(quantity: 0);
        $command = CartProductSetterCommandObjectMother::make(productId: $product->productId, quantity: -1);
        $cart = CartObjectMother::fromCartProductSetterCommand($command, ProductCollection::init());

        $this->expectException(ProductException::class);
        $this->expectExceptionMessage("Product cart quantity can't be negative");

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('searchProduct')
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
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartProductSetterCommandHandler->dispatch($command);
    }
}
