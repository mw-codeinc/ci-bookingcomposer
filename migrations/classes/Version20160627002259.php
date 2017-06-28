<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160627002259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql
        ("
			INSERT INTO `room` (`id_company`, `name`, `date_create`)
			VALUES
                (1, 'Gabinet 1', NOW()),
                (1, 'Gabinet 2', NOW()),
                (1, 'Gabinet 3', NOW());
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql
        ("
			DELETE FROM `room`;
        	ALTER TABLE `room` AUTO_INCREMENT = 1;
		");
    }
}
