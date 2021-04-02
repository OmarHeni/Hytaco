<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402003322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postlik (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_FD1B45744B89032C (post_id), INDEX IDX_FD1B4574A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programmes_utilisateur (programmes_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_7CDFDDCDA0A1C920 (programmes_id), INDEX IDX_7CDFDDCDFB88E14F (utilisateur_id), PRIMARY KEY(programmes_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postlik ADD CONSTRAINT FK_FD1B45744B89032C FOREIGN KEY (post_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE postlik ADD CONSTRAINT FK_FD1B4574A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE programmes_utilisateur ADD CONSTRAINT FK_7CDFDDCDA0A1C920 FOREIGN KEY (programmes_id) REFERENCES programmes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmes_utilisateur ADD CONSTRAINT FK_7CDFDDCDFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD user_id INT DEFAULT NULL, ADD locaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC2ADAA560 FOREIGN KEY (locaux_id) REFERENCES locaux (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA76ED395 ON commentaire (user_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC2ADAA560 ON commentaire (locaux_id)');
        $this->addSql('ALTER TABLE locaux ADD google_map VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE programmes ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programmes ADD CONSTRAINT FK_3631FC3FE559DFD1 FOREIGN KEY (locale_id) REFERENCES locaux (id)');
        $this->addSql('CREATE INDEX IDX_3631FC3FE559DFD1 ON programmes (locale_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A25649755126AC48 ON transporteur (mail)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE postlik');
        $this->addSql('DROP TABLE programmes_utilisateur');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2ADAA560');
        $this->addSql('DROP INDEX IDX_67F068BCA76ED395 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC2ADAA560 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP user_id, DROP locaux_id');
        $this->addSql('ALTER TABLE locaux DROP google_map');
        $this->addSql('ALTER TABLE programmes DROP FOREIGN KEY FK_3631FC3FE559DFD1');
        $this->addSql('DROP INDEX IDX_3631FC3FE559DFD1 ON programmes');
        $this->addSql('ALTER TABLE programmes DROP locale_id');
        $this->addSql('DROP INDEX UNIQ_A25649755126AC48 ON transporteur');
    }
}
