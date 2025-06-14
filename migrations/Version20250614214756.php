<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614214756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_78B2F932A76ED395 (user_id), PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_posts ADD CONSTRAINT FK_78B2F932A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_posts DROP FOREIGN KEY FK_78B2F932A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blog_posts
        SQL);
    }
}
