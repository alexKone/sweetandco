<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723152040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C98B963200D');
        $this->addSql('DROP INDEX UNIQ_605C9C98B963200D ON formule');
        $this->addSql('ALTER TABLE formule DROP addons_id');
        $this->addSql('ALTER TABLE salade ADD addons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salade ADD CONSTRAINT FK_9C8A52E9B963200D FOREIGN KEY (addons_id) REFERENCES addons (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C8A52E9B963200D ON salade (addons_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule ADD addons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C98B963200D FOREIGN KEY (addons_id) REFERENCES addons (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_605C9C98B963200D ON formule (addons_id)');
        $this->addSql('ALTER TABLE salade DROP FOREIGN KEY FK_9C8A52E9B963200D');
        $this->addSql('DROP INDEX UNIQ_9C8A52E9B963200D ON salade');
        $this->addSql('ALTER TABLE salade DROP addons_id');
    }
}
