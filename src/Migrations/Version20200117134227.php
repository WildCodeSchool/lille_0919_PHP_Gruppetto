<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200117134227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, sport_category_id INT NOT NULL, sport_name VARCHAR(255) NOT NULL, INDEX IDX_1A85EFD27173D9A4 (sport_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_event (id INT AUTO_INCREMENT NOT NULL, profil_solo_id INT DEFAULT NULL, event_id INT NOT NULL, INDEX IDX_B404AA4F9ADD062D (profil_solo_id), INDEX IDX_B404AA4F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, creator_solo_id INT DEFAULT NULL, creator_club_id INT DEFAULT NULL, name_event VARCHAR(255) NOT NULL, level_event INT DEFAULT NULL, date_event DATE NOT NULL, time_event TIME NOT NULL, description LONGTEXT DEFAULT NULL, participant_limit INT NOT NULL, place_event VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7AC78BCF8 (sport_id), INDEX IDX_3BAE0AA7915B7008 (creator_solo_id), INDEX IDX_3BAE0AA7EF8BB346 (creator_club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_solo_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6499ADD062D (profil_solo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profil_club (user_id INT NOT NULL, profil_club_id INT NOT NULL, INDEX IDX_19ADE105A76ED395 (user_id), INDEX IDX_19ADE105E40DC563 (profil_club_id), PRIMARY KEY(user_id, profil_club_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_club (id INT AUTO_INCREMENT NOT NULL, name_club VARCHAR(255) NOT NULL, city_club VARCHAR(255) NOT NULL, logo_club VARCHAR(255) NOT NULL, description_club LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_club_sport (profil_club_id INT NOT NULL, sport_id INT NOT NULL, INDEX IDX_812D9E9EE40DC563 (profil_club_id), INDEX IDX_812D9E9EAC78BCF8 (sport_id), PRIMARY KEY(profil_club_id, sport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, profil_solo_id INT NOT NULL, content LONGTEXT NOT NULL, date_comment DATETIME NOT NULL, INDEX IDX_9474526C71F7E88B (event_id), INDEX IDX_9474526C9ADD062D (profil_solo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE general_chat_club (id INT AUTO_INCREMENT NOT NULL, profil_club_id INT NOT NULL, profil_solo_id INT DEFAULT NULL, date_message DATETIME NOT NULL, content_message LONGTEXT NOT NULL, INDEX IDX_FD46B7B4E40DC563 (profil_club_id), INDEX IDX_FD46B7B49ADD062D (profil_solo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, answer LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE private_chat_club (id INT AUTO_INCREMENT NOT NULL, profil_club_id INT NOT NULL, profil_solo_id INT NOT NULL, content LONGTEXT NOT NULL, date_message DATETIME NOT NULL, UNIQUE INDEX UNIQ_B6B2ECB9E40DC563 (profil_club_id), UNIQUE INDEX UNIQ_B6B2ECB99ADD062D (profil_solo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, begin_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_event (booking_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_AAD2F7123301C60 (booking_id), INDEX IDX_AAD2F71271F7E88B (event_id), PRIMARY KEY(booking_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_category (id INT AUTO_INCREMENT NOT NULL, name_category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, profil_solo_id INT NOT NULL, friend_id INT NOT NULL, content_message LONGTEXT NOT NULL, date_message DATETIME NOT NULL, UNIQUE INDEX UNIQ_659DF2AA9ADD062D (profil_solo_id), UNIQUE INDEX UNIQ_659DF2AA6A5458E8 (friend_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friend (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_solo (id INT AUTO_INCREMENT NOT NULL, profil_club_id INT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, description LONGTEXT DEFAULT NULL, gender TINYINT(1) NOT NULL, avatar VARCHAR(255) NOT NULL, emergency_contact_name VARCHAR(255) DEFAULT NULL, level INT NOT NULL, sport_frequency INT NOT NULL, phone INT DEFAULT NULL, emergency_phone INT DEFAULT NULL, INDEX IDX_75814F3E40DC563 (profil_club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_solo_sport (profil_solo_id INT NOT NULL, sport_id INT NOT NULL, INDEX IDX_9D2D68739ADD062D (profil_solo_id), INDEX IDX_9D2D6873AC78BCF8 (sport_id), PRIMARY KEY(profil_solo_id, sport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_solo_friend (profil_solo_id INT NOT NULL, friend_id INT NOT NULL, INDEX IDX_F4B897989ADD062D (profil_solo_id), INDEX IDX_F4B897986A5458E8 (friend_id), PRIMARY KEY(profil_solo_id, friend_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT FK_1A85EFD27173D9A4 FOREIGN KEY (sport_category_id) REFERENCES sport_category (id)');
        $this->addSql('ALTER TABLE registration_event ADD CONSTRAINT FK_B404AA4F9ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE registration_event ADD CONSTRAINT FK_B404AA4F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7915B7008 FOREIGN KEY (creator_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7EF8BB346 FOREIGN KEY (creator_club_id) REFERENCES profil_club (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE user_profil_club ADD CONSTRAINT FK_19ADE105A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_profil_club ADD CONSTRAINT FK_19ADE105E40DC563 FOREIGN KEY (profil_club_id) REFERENCES profil_club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_club_sport ADD CONSTRAINT FK_812D9E9EE40DC563 FOREIGN KEY (profil_club_id) REFERENCES profil_club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_club_sport ADD CONSTRAINT FK_812D9E9EAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE general_chat_club ADD CONSTRAINT FK_FD46B7B4E40DC563 FOREIGN KEY (profil_club_id) REFERENCES profil_club (id)');
        $this->addSql('ALTER TABLE general_chat_club ADD CONSTRAINT FK_FD46B7B49ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE private_chat_club ADD CONSTRAINT FK_B6B2ECB9E40DC563 FOREIGN KEY (profil_club_id) REFERENCES profil_club (id)');
        $this->addSql('ALTER TABLE private_chat_club ADD CONSTRAINT FK_B6B2ECB99ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE booking_event ADD CONSTRAINT FK_AAD2F7123301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_event ADD CONSTRAINT FK_AAD2F71271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA9ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA6A5458E8 FOREIGN KEY (friend_id) REFERENCES friend (id)');
        $this->addSql('ALTER TABLE profil_solo ADD CONSTRAINT FK_75814F3E40DC563 FOREIGN KEY (profil_club_id) REFERENCES profil_club (id)');
        $this->addSql('ALTER TABLE profil_solo_sport ADD CONSTRAINT FK_9D2D68739ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_solo_sport ADD CONSTRAINT FK_9D2D6873AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_solo_friend ADD CONSTRAINT FK_F4B897989ADD062D FOREIGN KEY (profil_solo_id) REFERENCES profil_solo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_solo_friend ADD CONSTRAINT FK_F4B897986A5458E8 FOREIGN KEY (friend_id) REFERENCES friend (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7AC78BCF8');
        $this->addSql('ALTER TABLE profil_club_sport DROP FOREIGN KEY FK_812D9E9EAC78BCF8');
        $this->addSql('ALTER TABLE profil_solo_sport DROP FOREIGN KEY FK_9D2D6873AC78BCF8');
        $this->addSql('ALTER TABLE registration_event DROP FOREIGN KEY FK_B404AA4F71F7E88B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C71F7E88B');
        $this->addSql('ALTER TABLE booking_event DROP FOREIGN KEY FK_AAD2F71271F7E88B');
        $this->addSql('ALTER TABLE user_profil_club DROP FOREIGN KEY FK_19ADE105A76ED395');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7EF8BB346');
        $this->addSql('ALTER TABLE user_profil_club DROP FOREIGN KEY FK_19ADE105E40DC563');
        $this->addSql('ALTER TABLE profil_club_sport DROP FOREIGN KEY FK_812D9E9EE40DC563');
        $this->addSql('ALTER TABLE general_chat_club DROP FOREIGN KEY FK_FD46B7B4E40DC563');
        $this->addSql('ALTER TABLE private_chat_club DROP FOREIGN KEY FK_B6B2ECB9E40DC563');
        $this->addSql('ALTER TABLE profil_solo DROP FOREIGN KEY FK_75814F3E40DC563');
        $this->addSql('ALTER TABLE booking_event DROP FOREIGN KEY FK_AAD2F7123301C60');
        $this->addSql('ALTER TABLE sport DROP FOREIGN KEY FK_1A85EFD27173D9A4');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA6A5458E8');
        $this->addSql('ALTER TABLE profil_solo_friend DROP FOREIGN KEY FK_F4B897986A5458E8');
        $this->addSql('ALTER TABLE registration_event DROP FOREIGN KEY FK_B404AA4F9ADD062D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7915B7008');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499ADD062D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9ADD062D');
        $this->addSql('ALTER TABLE general_chat_club DROP FOREIGN KEY FK_FD46B7B49ADD062D');
        $this->addSql('ALTER TABLE private_chat_club DROP FOREIGN KEY FK_B6B2ECB99ADD062D');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA9ADD062D');
        $this->addSql('ALTER TABLE profil_solo_sport DROP FOREIGN KEY FK_9D2D68739ADD062D');
        $this->addSql('ALTER TABLE profil_solo_friend DROP FOREIGN KEY FK_F4B897989ADD062D');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE registration_event');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_profil_club');
        $this->addSql('DROP TABLE profil_club');
        $this->addSql('DROP TABLE profil_club_sport');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE general_chat_club');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE private_chat_club');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_event');
        $this->addSql('DROP TABLE sport_category');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE friend');
        $this->addSql('DROP TABLE profil_solo');
        $this->addSql('DROP TABLE profil_solo_sport');
        $this->addSql('DROP TABLE profil_solo_friend');
    }
}
