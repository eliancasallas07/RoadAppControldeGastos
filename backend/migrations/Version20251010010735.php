<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251010010735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehiculo (id INT AUTO_INCREMENT NOT NULL, marca VARCHAR(255) NOT NULL, numero_chasis VARCHAR(255) NOT NULL, numero_motor VARCHAR(255) NOT NULL, cilindrada VARCHAR(255) NOT NULL, modelo VARCHAR(255) NOT NULL, linea VARCHAR(255) NOT NULL, potencia_hp VARCHAR(255) NOT NULL, declaracion_importacion VARCHAR(255) NOT NULL, fecha_importacion VARCHAR(255) NOT NULL, puertas VARCHAR(255) NOT NULL, fecha_matricula VARCHAR(255) NOT NULL, organismo_transito VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, tipo_carroceria VARCHAR(255) NOT NULL, combustible VARCHAR(255) NOT NULL, capacidad VARCHAR(255) NOT NULL, propietario VARCHAR(255) NOT NULL, identificacion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE viaje (id BIGINT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, origen VARCHAR(255) NOT NULL, destino VARCHAR(255) NOT NULL, vehiculo VARCHAR(255) NOT NULL, conductor VARCHAR(255) NOT NULL, fecha DATE NOT NULL, created_at DATETIME NOT NULL, valor_flete DOUBLE PRECISION DEFAULT NULL, comision DOUBLE PRECISION DEFAULT NULL, cargue_valor DOUBLE PRECISION DEFAULT NULL, descargue_valor DOUBLE PRECISION DEFAULT NULL, descarrozar DOUBLE PRECISION DEFAULT NULL, peajes DOUBLE PRECISION DEFAULT NULL, acpm DOUBLE PRECISION DEFAULT NULL, parqueos DOUBLE PRECISION DEFAULT NULL, lavados DOUBLE PRECISION DEFAULT NULL, reparaciones DOUBLE PRECISION DEFAULT NULL, descuentos DOUBLE PRECISION DEFAULT NULL, documentos VARCHAR(255) DEFAULT NULL, peso_kilos DOUBLE PRECISION DEFAULT NULL, tipo_carga VARCHAR(255) DEFAULT NULL, INDEX IDX_1D41ED16DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE viaje ADD CONSTRAINT FK_1D41ED16DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE viaje DROP FOREIGN KEY FK_1D41ED16DB38439E');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehiculo');
        $this->addSql('DROP TABLE viaje');
    }
}
