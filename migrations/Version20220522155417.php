<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522155417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE packs (dog_id INT NOT NULL, pack_dog_id INT NOT NULL, PRIMARY KEY(dog_id, pack_dog_id))');
        $this->addSql('CREATE INDEX IDX_B9FE6027634DFEB ON packs (dog_id)');
        $this->addSql('CREATE INDEX IDX_B9FE602721846ACB ON packs (pack_dog_id)');
        $this->addSql('ALTER TABLE packs ADD CONSTRAINT FK_B9FE6027634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE packs ADD CONSTRAINT FK_B9FE602721846ACB FOREIGN KEY (pack_dog_id) REFERENCES dogs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE packs');
    }
}
