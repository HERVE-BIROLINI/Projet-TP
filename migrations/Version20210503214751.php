<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503214751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, region VARCHAR(255) NOT NULL, capacity VARCHAR(255) NOT NULL, price NUMERIC(7, 2) NOT NULL, score NUMERIC(2, 1) NOT NULL, INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, creationdate DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_CE17A058A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kart_item (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, kart_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4B26873F7294869C (article_id), INDEX IDX_4B26873F293A83D8 (kart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, pathname VARCHAR(255) NOT NULL, INDEX IDX_16DB4F897294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(128) NOT NULL, birthdate DATE NOT NULL, hasagreetoterms TINYINT(1) NOT NULL, inscriptiondate DATE NOT NULL, address VARCHAR(128) DEFAULT NULL, postalcode NUMERIC(5, 0) DEFAULT NULL, city VARCHAR(64) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE kart ADD CONSTRAINT FK_CE17A058A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE kart_item ADD CONSTRAINT FK_4B26873F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE kart_item ADD CONSTRAINT FK_4B26873F293A83D8 FOREIGN KEY (kart_id) REFERENCES kart (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F897294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kart_item DROP FOREIGN KEY FK_4B26873F7294869C');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F897294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE kart_item DROP FOREIGN KEY FK_4B26873F293A83D8');
        $this->addSql('ALTER TABLE kart DROP FOREIGN KEY FK_CE17A058A76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE kart');
        $this->addSql('DROP TABLE kart_item');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE user');
    }
}
