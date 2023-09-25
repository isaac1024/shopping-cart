<?php

declare(strict_types=1);

namespace ShoppingCart\Tests\Shared\Infrastructure\PhpUnit;

use App\Service\AmqpMessage;
use Doctrine\DBAL\Connection;
use ShoppingCart\Shared\Domain\Bus\Event;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

abstract class AcceptanceTestCase extends WebTestCase
{
    use InteractsWithMessenger;

    private KernelBrowser $client;
    private Connection $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->connection = $this->client->getContainer()->get('doctrine.dbal.default_connection');
    }

    protected function json(string $method, string $uri, array $parameters = []): void
    {
        $this->client->jsonRequest($method, $uri, $parameters);
    }

    protected function response(): ?array
    {
        $response = $this->client->getResponse()->getContent();
        return $response ? json_decode($response, true) : null;
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

    protected function sendEvent(array $event): void
    {
        $this->transport('event')->send($event);
    }

    protected function prepareRecord(string $table, array $data): void
    {
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            join(', ', array_keys($data)),
            join(', ', array_map(fn (string $key) => sprintf(":%s", $key), array_keys($data))),
        );
        $this->connection->executeQuery($sql, $data);
    }

    protected function assertHasDatabase(string $table, array $data): void
    {
        $where = array_map(fn (string $key) => sprintf("%s = :%s", $key, $key), array_keys($data));
        $sql = sprintf("SELECT id FROM %s WHERE %s", $table, join(' AND ', $where));
        self::assertIsArray($this->connection->fetchAssociative($sql, $data));
    }
}
