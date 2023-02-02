<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202175833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552F43A116');
        $this->addSql('DROP INDEX IDX_42C849552F43A116 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD lender_id INT DEFAULT NULL, CHANGE gamer_id taker_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B2E74C3 FOREIGN KEY (taker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955855D3E3D FOREIGN KEY (lender_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C84955B2E74C3 ON reservation (taker_id)');
        $this->addSql('CREATE INDEX IDX_42C84955855D3E3D ON reservation (lender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B2E74C3');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955855D3E3D');
        $this->addSql('DROP INDEX IDX_42C84955B2E74C3 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955855D3E3D ON reservation');
        $this->addSql('ALTER TABLE reservation DROP lender_id, CHANGE taker_id gamer_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552F43A116 FOREIGN KEY (gamer_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_42C849552F43A116 ON reservation (gamer_id)');
    }
}
