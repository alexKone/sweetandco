<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704122949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE base (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salade (id INT AUTO_INCREMENT NOT NULL, base_id INT DEFAULT NULL, sauce_id INT DEFAULT NULL, INDEX IDX_9C8A52E96967DF41 (base_id), INDEX IDX_9C8A52E97AB984B7 (sauce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salade_ingredient (salade_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_6229683045927B6B (salade_id), INDEX IDX_62296830933FE08C (ingredient_id), PRIMARY KEY(salade_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sauce (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salade ADD CONSTRAINT FK_9C8A52E96967DF41 FOREIGN KEY (base_id) REFERENCES base (id)');
        $this->addSql('ALTER TABLE salade ADD CONSTRAINT FK_9C8A52E97AB984B7 FOREIGN KEY (sauce_id) REFERENCES sauce (id)');
        $this->addSql('ALTER TABLE salade_ingredient ADD CONSTRAINT FK_6229683045927B6B FOREIGN KEY (salade_id) REFERENCES salade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salade_ingredient ADD CONSTRAINT FK_62296830933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salade DROP FOREIGN KEY FK_9C8A52E96967DF41');
        $this->addSql('ALTER TABLE salade_ingredient DROP FOREIGN KEY FK_62296830933FE08C');
        $this->addSql('ALTER TABLE salade_ingredient DROP FOREIGN KEY FK_6229683045927B6B');
        $this->addSql('ALTER TABLE salade DROP FOREIGN KEY FK_9C8A52E97AB984B7');
        $this->addSql('DROP TABLE base');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE salade');
        $this->addSql('DROP TABLE salade_ingredient');
        $this->addSql('DROP TABLE sauce');
    }
}
