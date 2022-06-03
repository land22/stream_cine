<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603200527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, localisation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cinema_video (cinema_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_F748452AB4CB84B6 (cinema_id), INDEX IDX_F748452A29C1004E (video_id), PRIMARY KEY(cinema_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projection (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, cinema_id INT DEFAULT NULL, user_id INT DEFAULT NULL, heure_projection DATETIME NOT NULL, INDEX IDX_8004C82629C1004E (video_id), INDEX IDX_8004C826B4CB84B6 (cinema_id), INDEX IDX_8004C826A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, projection_id INT DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C849555ECF66BD (projection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cinema_video ADD CONSTRAINT FK_F748452AB4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cinema_video ADD CONSTRAINT FK_F748452A29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projection ADD CONSTRAINT FK_8004C82629C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE projection ADD CONSTRAINT FK_8004C826B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id)');
        $this->addSql('ALTER TABLE projection ADD CONSTRAINT FK_8004C826A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555ECF66BD FOREIGN KEY (projection_id) REFERENCES projection (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cinema_video DROP FOREIGN KEY FK_F748452AB4CB84B6');
        $this->addSql('ALTER TABLE projection DROP FOREIGN KEY FK_8004C826B4CB84B6');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555ECF66BD');
        $this->addSql('DROP TABLE cinema');
        $this->addSql('DROP TABLE cinema_video');
        $this->addSql('DROP TABLE projection');
        $this->addSql('DROP TABLE reservation');
    }
}
