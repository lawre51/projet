<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609164728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, materiel_id INT NOT NULL, date DATETIME NOT NULL, status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description LONGTEXT NOT NULL, signature TINYINT(1) DEFAULT NULL, type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_D11814AB16880AAF (materiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_user (intervention_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_822CCE8B8EAE3863 (intervention_id), INDEX IDX_822CCE8BA76ED395 (user_id), PRIMARY KEY(intervention_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, implantation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, intervention_id INT NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_5FB6DEC7A76ED395 (user_id), INDEX IDX_5FB6DEC78EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB16880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE intervention_user ADD CONSTRAINT FK_822CCE8B8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_user ADD CONSTRAINT FK_822CCE8BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC78EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD equipe INT NOT NULL, ADD poste VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB16880AAF');
        $this->addSql('ALTER TABLE intervention_user DROP FOREIGN KEY FK_822CCE8B8EAE3863');
        $this->addSql('ALTER TABLE intervention_user DROP FOREIGN KEY FK_822CCE8BA76ED395');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7A76ED395');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC78EAE3863');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_user');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP equipe, DROP poste');
    }
}
