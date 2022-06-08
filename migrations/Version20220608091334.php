<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608091334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cinema ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema ADD CONSTRAINT FK_D48304B4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D48304B4A76ED395 ON cinema (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cinema DROP FOREIGN KEY FK_D48304B4A76ED395');
        $this->addSql('DROP INDEX IDX_D48304B4A76ED395 ON cinema');
        $this->addSql('ALTER TABLE cinema DROP user_id');
    }
}
