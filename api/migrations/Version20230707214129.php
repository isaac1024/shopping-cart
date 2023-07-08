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

        $this->addSql(<<<SQL
            INSERT INTO products (id, title, description, photo, price)
            VALUES ('824ee66a-42c2-48d2-99af-0be1653c51ef', 'The software craftsman', 'In The Software Craftsman: Professionalism, Pragmatism, Pride, Sandro Mancuso offers a better and more fulfilling path.', '/photos/the-software-craftsman.jpg', 3399),
                   ('0dc19bc6-2520-430b-9ed6-b1dc6bcfe01e', 'Clean Agile', 'Agile Values and Principles for a New Generation.', '/photos/clean-agile.jpg', 2944),
                   ('307028d4-8a2f-4441-a3ac-0c904c12bf86', 'Domain-Driven Design', 'Software design thought leader and founder of Domain Language, Eric Evans, provides a systematic approach to domain-driven design, presenting an extensive set of design best practices, experience-based techniques, and fundamental principles that facilitate the development of software projects facing complex domains.', '/photos/ddd.jpg', 4876),
                   ('b473ca32-d86a-4ec6-83cb-1747a372a300', 'Implementing Domain-Driven Design', 'Implementing Domain-Driven Design presents a top-down approach to understanding domain-driven design (DDD) in a way that fluently connects strategic patterns to fundamental tactical programming tools.', '/photos/implementing-ddd.jpg', 4874),
                   ('46295305-bd8d-42ce-a807-83a35c0ca44f', 'Domain-Driven Design in PHP', 'Master Domain-Driven Design Tactical patterns: Entities, Value Objects, Services, Domain Events, Aggregates, Factories, Repositories and Application Services; with real examples in PHP.', '/photos/ddd-php.png', 3499),
                   ('dea6cb68-bc48-4b58-8ddf-ac8d9b7f2c31', 'Clean Code', 'Clean Code is divided into three parts. The first describes the principles, patterns, and practices of writing clean code.', '/photos/clean-code.jpg', 4055),
                   ('d2d7d6d8-b056-492f-b703-99884085c862', 'Clean Architecture', 'As with his other books, Martin\'s Clean Architecture doesn\'t merely present multiple choices and options, and say "use your best judgment": it tells you what choices to make, and why those choices are critical to your success. Martin offers direct, no-nonsense answers to key architecture and design questions.', '/photos/clean-architecture.jpg', 3137);
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE products;
        SQL);
    }
}
