<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160627002048 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql
        ("
			INSERT INTO `company` (`id`, `name`, `date_create`)
			VALUES
                (1, 'Q10 Spa', NOW());
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql
        ("
			DELETE FROM `company`;
        	ALTER TABLE `company` AUTO_INCREMENT = 1;
		");
    }
}
