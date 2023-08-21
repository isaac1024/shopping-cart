<?php

declare(strict_types=1);

namespace ShoppingCart\Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

abstract class AcceptanceTestCase extends WebTestCase
{
    use InteractsWithMessenger;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    protected function json(string $method, string $uri, array $parameters = []): void
    {
        $this->client->jsonRequest($method, $uri, $parameters);
    }

    protected function getRepository(string $repositoryName)
    {
        return $this->client->getContainer()->get($repositoryName);
    }

    protected function assertSendEvents(array $expected): void
    {
        $routings = [];
        foreach ($this->transport('event')->queue() as $envelope) {
            /** @var AmqpStamp|null $amqpStamp */
            $amqpStamp = $envelope->last(AmqpStamp::class);
            if ($amqpStamp) {
                $routings[] = $amqpStamp->getRoutingKey();
            }
        }

        self::assertEquals($expected, $routings);
    }
}
