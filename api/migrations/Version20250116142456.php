<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116142456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, the_table_id INT DEFAULT NULL, client_id INT DEFAULT NULL, date DATETIME NOT NULL, datetime TIME NOT NULL, number_of_people INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_4DA239A576BD3F (the_table_id), INDEX IDX_4DA23919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tables (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, capacity INT NOT NULL, location VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A576BD3F FOREIGN KEY (the_table_id) REFERENCES tables (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23919EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A576BD3F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, capacity INT NOT NULL, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, the_table_id INT DEFAULT NULL, client_id INT DEFAULT NULL, date DATETIME NOT NULL, datetime TIME NOT NULL, number_of_people INT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_42C84955A576BD3F (the_table_id), INDEX IDX_42C8495519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A576BD3F FOREIGN KEY (the_table_id) REFERENCES `table` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A576BD3F');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23919EB6921');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE tables');
    }
}
