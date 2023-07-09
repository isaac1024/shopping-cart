<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709160509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create orders table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE orders (
                id UUID NOT NULL,
                cart_id UUID NOT NULL,
                status VARCHAR(32) NOT NULL,
                address VARCHAR(255) NOT NULL,
                name VARCHAR(180) NOT NULL,
                number_items INTEGER NOT NULL,
                total_amount INTEGER NOT NULL,
                product_items JSON NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE orders;
        SQL);
    }
}
