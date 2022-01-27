<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509040226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE services');
        $this->addSql('ALTER TABLE call_for_proposal ADD number_of_co_pi INT DEFAULT NULL, ADD allow_non_academic_staff_as_pi TINYINT(1) DEFAULT NULL, ADD allow_researcher_from_another_college TINYINT(1) DEFAULT NULL, ADD allow_pi_from_other_university TINYINT(1) DEFAULT NULL, ADD funding_source VARCHAR(255) DEFAULT NULL, ADD commitment_from_other_research TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, launch_year DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE call_for_proposal DROP number_of_co_pi, DROP allow_non_academic_staff_as_pi, DROP allow_researcher_from_another_college, DROP allow_pi_from_other_university, DROP funding_source, DROP commitment_from_other_research');
    }
}
