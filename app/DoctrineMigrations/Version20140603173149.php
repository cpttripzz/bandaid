<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140603173149 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE band_genre DROP FOREIGN KEY FK_7FB28D6449ABEB17");
        $this->addSql("CREATE TABLE google_geolocation_location (id INT AUTO_INCREMENT NOT NULL, search VARCHAR(255) NOT NULL, matches SMALLINT NOT NULL, status VARCHAR(20) NOT NULL, result LONGTEXT NOT NULL, hits INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE google_geolocation_api_log (id INT AUTO_INCREMENT NOT NULL, lastStatus VARCHAR(20) NOT NULL, requests INT NOT NULL, created DATE NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_26CE10BDB23DB7B8 (created), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Region (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, short_name VARCHAR(255) NOT NULL, long_name VARCHAR(255) NOT NULL, INDEX IDX_8CEF440F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Region ADD CONSTRAINT FK_8CEF440F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)");
        $this->addSql("DROP TABLE Band");
        $this->addSql("DROP TABLE band_genre");
        $this->addSql("ALTER TABLE city ADD region_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES Region (id)");
        $this->addSql("CREATE INDEX IDX_2D5B023498260155 ON city (region_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155");
        $this->addSql("CREATE TABLE Band (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, description TEXT DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_E8ED0DD5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE band_genre (band_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_7FB28D6449ABEB17 (band_id), INDEX IDX_7FB28D644296D31F (genre_id), PRIMARY KEY(band_id, genre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE band_genre ADD CONSTRAINT FK_7FB28D6449ABEB17 FOREIGN KEY (band_id) REFERENCES Band (id)");
        $this->addSql("DROP TABLE google_geolocation_location");
        $this->addSql("DROP TABLE google_geolocation_api_log");
        $this->addSql("DROP TABLE Region");
        $this->addSql("DROP INDEX IDX_2D5B023498260155 ON city");
        $this->addSql("ALTER TABLE city DROP region_id");
    }
}
