<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330235215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraisons ADD livreur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraisons ADD CONSTRAINT FK_96A0CE61F8646701 FOREIGN KEY (livreur_id) REFERENCES livreurs (id)');
        $this->addSql('CREATE INDEX IDX_96A0CE61F8646701 ON livraisons (livreur_id)');
        $this->addSql('ALTER TABLE locaux ADD note INT DEFAULT NULL, CHANGE nom nom VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraisons DROP FOREIGN KEY FK_96A0CE61F8646701');
        $this->addSql('DROP INDEX IDX_96A0CE61F8646701 ON livraisons');
        $this->addSql('ALTER TABLE livraisons DROP livreur_id');
        $this->addSql('ALTER TABLE locaux DROP note, CHANGE nom nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
