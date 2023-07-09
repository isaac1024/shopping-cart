<?php

declare(strict_types=1);

namespace ShoppingCart\Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
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

    protected function assertSendEvent(string $eventClass, int $times = 1): void
    {
        $this->bus('event.bus')->dispatched()->assertContains($eventClass, $times);
    }
}
