<?php

declare(strict_types=1);

namespace ShoppingCart\Tests\Shared\Infrastructure\PhpUnit;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{
    private Connection $connection;
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->connection = $this->get('doctrine.dbal.default_connection');
    }

    protected function get(string $className)
    {
        return $this->getContainer()->get($className);
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
        $where = array_map(fn (string $key) => sprintf("%s=:%s", $key, $key), array_keys($data));
        $sql = sprintf("SELECT id FROM %s WHERE %s", $table, join(' AND ', $where));
        self::assertIsArray($this->connection->fetchAssociative($sql, $data));
    }
}
