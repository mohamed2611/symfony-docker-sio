<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203101338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follow_up (id INT AUTO_INCREMENT NOT NULL, veterinary_id INT NOT NULL, contact_name VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, call_date DATE NOT NULL, INDEX IDX_7BBC5A9CD954EB99 (veterinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, veterinary_id INT NOT NULL, product_id INT NOT NULL, amount NUMERIC(12, 2) NOT NULL, year INT NOT NULL, INDEX IDX_FCDCEB2ED954EB99 (veterinary_id), INDEX IDX_FCDCEB2E4584665A (product_id), UNIQUE INDEX UQ_Goal (veterinary_id, product_id, year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, phonep VARCHAR(25) NOT NULL, image_file_name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_8B49EF5712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary_activity (veterinary_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_6B9383F9D954EB99 (veterinary_id), INDEX IDX_6B9383F981C06096 (activity_id), PRIMARY KEY(veterinary_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follow_up ADD CONSTRAINT FK_7BBC5A9CD954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2ED954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE veterinary ADD CONSTRAINT FK_8B49EF5712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE veterinary_activity ADD CONSTRAINT FK_6B9383F9D954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE veterinary_activity ADD CONSTRAINT FK_6B9383F981C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follow_up DROP FOREIGN KEY FK_7BBC5A9CD954EB99');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2ED954EB99');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E4584665A');
        $this->addSql('ALTER TABLE veterinary DROP FOREIGN KEY FK_8B49EF5712469DE2');
        $this->addSql('ALTER TABLE veterinary_activity DROP FOREIGN KEY FK_6B9383F9D954EB99');
        $this->addSql('ALTER TABLE veterinary_activity DROP FOREIGN KEY FK_6B9383F981C06096');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE follow_up');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE veterinary');
        $this->addSql('DROP TABLE veterinary_activity');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
