<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230707214129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE products (
                id UUID NOT NULL,
                title VARCHAR(180) NOT NULL,
                description TEXT NOT NULL,
                photo VARCHAR(255) NOT NULL,
                price INTEGER NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE products;
        SQL);
    }
}
