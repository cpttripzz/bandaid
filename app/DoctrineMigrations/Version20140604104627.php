<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140604104627 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE region ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL");
        $this->addSql("DROP INDEX idx_8cef440f92f3e70 ON region");
        $this->addSql("CREATE INDEX IDX_F62F176F92F3E70 ON region (country_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE region DROP latitude, DROP longitude");
        $this->addSql("DROP INDEX idx_f62f176f92f3e70 ON region");
        $this->addSql("CREATE INDEX IDX_8CEF440F92F3E70 ON region (country_id)");
    }
}
