<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201133226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_activity (user_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_4CF9ED5AA76ED395 (user_id), INDEX IDX_4CF9ED5A81C06096 (activity_id), PRIMARY KEY(user_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_4CF9ED5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_4CF9ED5A81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA767B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA767B3B43D ON event (users_id)');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD birthday DATETIME DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD car TINYINT(1) DEFAULT NULL, ADD handicap TINYINT(1) DEFAULT NULL, ADD presentation LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_activity DROP FOREIGN KEY FK_4CF9ED5AA76ED395');
        $this->addSql('ALTER TABLE user_activity DROP FOREIGN KEY FK_4CF9ED5A81C06096');
        $this->addSql('DROP TABLE user_activity');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA767B3B43D');
        $this->addSql('DROP INDEX IDX_3BAE0AA767B3B43D ON event');
        $this->addSql('ALTER TABLE event DROP users_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP email, DROP name, DROP lastname, DROP birthday, DROP city, DROP car, DROP handicap, DROP presentation');
    }
}
