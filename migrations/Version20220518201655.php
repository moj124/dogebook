<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518201655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE posts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE posts (id INT NOT NULL, dog_id INT NOT NULL, post_text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_885DBAFA634DFEB ON posts (dog_id)');
        $this->addSql('COMMENT ON COLUMN posts.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE post');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE posts_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, dog_id INT NOT NULL, post_text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_5a8a6c8d634dfeb ON post (dog_id)');
        $this->addSql('COMMENT ON COLUMN post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d634dfeb FOREIGN KEY (dog_id) REFERENCES dogs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE posts');
    }
}
