<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120134543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE asset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wallet_asset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wallet_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE asset (id INT NOT NULL, name VARCHAR(100) NOT NULL, symbol VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE wallet_asset (id INT NOT NULL, wallet_id INT NOT NULL, asset_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_72A83C26712520F3 ON wallet_asset (wallet_id)');
        $this->addSql('CREATE INDEX IDX_72A83C265DA1941 ON wallet_asset (asset_id)');
        $this->addSql('CREATE TABLE wallet_type (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE wallet_asset ADD CONSTRAINT FK_72A83C26712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet_asset ADD CONSTRAINT FK_72A83C265DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FC54C8C93 FOREIGN KEY (type_id) REFERENCES wallet_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C68921FC54C8C93 ON wallet (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921FC54C8C93');
        $this->addSql('DROP SEQUENCE asset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wallet_asset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wallet_type_id_seq CASCADE');
        $this->addSql('ALTER TABLE wallet_asset DROP CONSTRAINT FK_72A83C26712520F3');
        $this->addSql('ALTER TABLE wallet_asset DROP CONSTRAINT FK_72A83C265DA1941');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE wallet_asset');
        $this->addSql('DROP TABLE wallet_type');
        $this->addSql('DROP INDEX IDX_7C68921FC54C8C93');
        $this->addSql('ALTER TABLE wallet DROP type_id');
    }
}
