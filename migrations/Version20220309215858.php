<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309215858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the dogs table (basically users)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE dog_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dogs (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_812C397DF85E0677 ON dogs (username)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE dog_id_seq CASCADE');
        $this->addSql('DROP TABLE dogs');
    }
}
