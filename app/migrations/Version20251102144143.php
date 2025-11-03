<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251102144143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add USER and ADMIN';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO role (role_name) VALUES ('USER'), ('ADMIN')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM role WHERE role_name IN ('USER'), ('ADMIN')");
    }

}
