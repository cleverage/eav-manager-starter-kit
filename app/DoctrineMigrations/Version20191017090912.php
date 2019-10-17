<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Changing embed resource data classes
 */
final class Version20191017090912 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE app_eav_data SET discr = 'authorlink' WHERE family_code = 'AuthorLink'");
        $this->addSql("UPDATE app_eav_data SET discr = 'editioncontributor' WHERE family_code = 'EditionContributor'");
        $this->addSql("UPDATE app_eav_data SET discr = 'language' WHERE family_code = 'Language'");
        $this->addSql("UPDATE app_eav_data SET discr = 'tableofcontentsentry' WHERE family_code = 'TableOfContentsEntry'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE app_eav_data SET discr = 'data' WHERE family_code = 'AuthorLink'");
        $this->addSql("UPDATE app_eav_data SET discr = 'data' WHERE family_code = 'EditionContributor'");
        $this->addSql("UPDATE app_eav_data SET discr = 'data' WHERE family_code = 'Language'");
        $this->addSql("UPDATE app_eav_data SET discr = 'data' WHERE family_code = 'TableOfContentsEntry'");
    }
}
