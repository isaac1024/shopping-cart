<?php

namespace ShoppingCart\Tests\Query\Payment\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Query\Payment\Application\PaymentSecretQueryHandler;
use ShoppingCart\Query\Payment\Domain\PaymentNotFoundException;
use ShoppingCart\Query\Payment\Domain\PaymentRepository;
use ShoppingCart\Query\Payment\Domain\PaymentSecretRepository;
use ShoppingCart\Tests\Query\Payment\Domain\PaymentObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class PaymentSecretQueryHandlerTest extends UnitTestCase
{
    private PaymentSecretQueryHandler $paymentSecretQueryHandler;
    private PaymentRepository&MockObject $paymentRepository;
    private PaymentSecretRepository&MockObject $paymentSecretRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentRepository = $this->getMockBuilder(PaymentRepository::class)->getMock();
        $this->paymentSecretRepository = $this->getMockBuilder(PaymentSecretRepository::class)->getMock();
        $this->paymentSecretQueryHandler = new PaymentSecretQueryHandler($this->paymentRepository, $this->paymentSecretRepository);
    }

    public function testGetPaymentSecret(): void
    {
        $query = PaymentSecretQueryObjectMother::make();
        $payment = PaymentObjectMother::fromPaymentSecretQuery($query);
        $expectedResponse = PaymentSecretQueryResponseObjectMother::make();

        $this->paymentRepository->expects($this->once())
            ->method('find')
            ->with($query->id)
            ->willReturn($payment);

        $this->paymentSecretRepository->expects($this->once())
            ->method('getSecret')
            ->with($payment)
            ->willReturn($expectedResponse->paymentSecret);

        $response = $this->paymentSecretQueryHandler->ask($query);
        self::assertEquals($expectedResponse, $response);
    }

    public function testGetPaymentSecretNotFoundPayment(): void
    {
        $query = PaymentSecretQueryObjectMother::make();
        $this->expectException(PaymentNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Not found payment with id "%s"', $query->id));

        $this->paymentRepository->expects($this->once())
            ->method('find')
            ->with($query->id)
            ->willReturn(null);

        $this->paymentSecretRepository->expects($this->never())
            ->method('getSecret');

        $this->paymentSecretQueryHandler->ask($query);
    }
}
