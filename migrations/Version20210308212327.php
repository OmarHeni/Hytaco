<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308212327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerts ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alerts ADD CONSTRAINT FK_F77AC06BFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_F77AC06BFB88E14F ON alerts (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerts DROP FOREIGN KEY FK_F77AC06BFB88E14F');
        $this->addSql('DROP INDEX IDX_F77AC06BFB88E14F ON alerts');
        $this->addSql('ALTER TABLE alerts DROP utilisateur_id');
    }
}
