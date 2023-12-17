<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217085204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attesstation_content ADD attestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attesstation_content ADD CONSTRAINT FK_78595357EDC5B38 FOREIGN KEY (attestation_id) REFERENCES attesstation (id)');
        $this->addSql('CREATE INDEX IDX_78595357EDC5B38 ON attesstation_content (attestation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attesstation_content DROP FOREIGN KEY FK_78595357EDC5B38');
        $this->addSql('DROP INDEX IDX_78595357EDC5B38 ON attesstation_content');
        $this->addSql('ALTER TABLE attesstation_content DROP attestation_id');
    }
}
