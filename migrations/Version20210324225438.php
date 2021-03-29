<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324225438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCEAB5DEB');
        $this->addSql('DROP INDEX IDX_67F068BCEAB5DEB ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE many_to_one_id locaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC2ADAA560 FOREIGN KEY (locaux_id) REFERENCES locaux (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC2ADAA560 ON commentaire (locaux_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2ADAA560');
        $this->addSql('DROP INDEX IDX_67F068BC2ADAA560 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE locaux_id many_to_one_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCEAB5DEB FOREIGN KEY (many_to_one_id) REFERENCES locaux (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCEAB5DEB ON commentaire (many_to_one_id)');
    }
}
