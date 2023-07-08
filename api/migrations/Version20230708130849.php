<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230708130849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create carts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE carts (
                id UUID NOT NULL,
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
            DROP TABLE carts;
        SQL);
    }
}
