<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104005347 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, summary LONGTEXT DEFAULT NULL, release_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_BDAFD8C87DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_editor (author_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_2932C797F675F31B (author_id), INDEX IDX_2932C7976995AC4C (editor_id), PRIMARY KEY(author_id, editor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, creation_date DATETIME NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C87DD8AC20 FOREIGN KEY (books_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE author_editor ADD CONSTRAINT FK_2932C797F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_editor ADD CONSTRAINT FK_2932C7976995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C87DD8AC20');
        $this->addSql('ALTER TABLE author_editor DROP FOREIGN KEY FK_2932C797F675F31B');
        $this->addSql('ALTER TABLE author_editor DROP FOREIGN KEY FK_2932C7976995AC4C');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_editor');
        $this->addSql('DROP TABLE editor');
    }
}
