<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251005144012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE viaje (id BIGINT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, origen VARCHAR(255) NOT NULL, destino VARCHAR(255) NOT NULL, vehiculo VARCHAR(255) NOT NULL, conductor VARCHAR(255) NOT NULL, fecha DATE NOT NULL, created_at DATETIME NOT NULL, valor_flete DOUBLE PRECISION DEFAULT NULL, comision DOUBLE PRECISION DEFAULT NULL, cargue_valor DOUBLE PRECISION DEFAULT NULL, descargue_valor DOUBLE PRECISION DEFAULT NULL, descarrozar DOUBLE PRECISION DEFAULT NULL, peajes DOUBLE PRECISION DEFAULT NULL, acpm DOUBLE PRECISION DEFAULT NULL, parqueos DOUBLE PRECISION DEFAULT NULL, lavados DOUBLE PRECISION DEFAULT NULL, reparaciones DOUBLE PRECISION DEFAULT NULL, descuentos DOUBLE PRECISION DEFAULT NULL, documentos VARCHAR(255) DEFAULT NULL, peso_kilos DOUBLE PRECISION DEFAULT NULL, tipo_carga VARCHAR(255) DEFAULT NULL, INDEX IDX_1D41ED16DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE viaje ADD CONSTRAINT FK_1D41ED16DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE viaje DROP FOREIGN KEY FK_1D41ED16DB38439E');
        $this->addSql('DROP TABLE viaje');
    }
}
