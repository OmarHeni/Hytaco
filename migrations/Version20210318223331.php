<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318223331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programmes DROP FOREIGN KEY FK_3631FC3F97C86FA4');
        $this->addSql('DROP INDEX IDX_3631FC3F97C86FA4 ON programmes');
        $this->addSql('ALTER TABLE programmes DROP transporteur_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programmes ADD transporteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programmes ADD CONSTRAINT FK_3631FC3F97C86FA4 FOREIGN KEY (transporteur_id) REFERENCES transporteur (id)');
        $this->addSql('CREATE INDEX IDX_3631FC3F97C86FA4 ON programmes (transporteur_id)');
    }
}
