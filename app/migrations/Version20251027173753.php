<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating ARTICLE_CATEGORY';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article_category (
            article_id CHAR(36) NOT NULL,
            category_id CHAR(36) NOT NULL,
            PRIMARY KEY(article_id, category_id),
            CONSTRAINT FK_ARTICLE_CATEGORY_ARTICLE FOREIGN KEY(article_id) REFERENCES article(article_id) ON DELETE CASCADE,
            CONSTRAINT FK_ARTICLE_CATEGORY_CATEGORY FOREIGN KEY(category_id) REFERENCES category(category_id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE article_category');
    }

}
