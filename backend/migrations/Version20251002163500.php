<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251002163500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehiculo (id INT AUTO_INCREMENT NOT NULL, marca VARCHAR(255) NOT NULL, numero_chasis VARCHAR(255) NOT NULL, numero_motor VARCHAR(255) NOT NULL, cilindrada VARCHAR(255) NOT NULL, modelo VARCHAR(255) NOT NULL, linea VARCHAR(255) NOT NULL, potencia_hp VARCHAR(255) NOT NULL, declaracion_importacion VARCHAR(255) NOT NULL, fecha_importacion VARCHAR(255) NOT NULL, puertas VARCHAR(255) NOT NULL, fecha_matricula VARCHAR(255) NOT NULL, organismo_transito VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, tipo_carroceria VARCHAR(255) NOT NULL, combustible VARCHAR(255) NOT NULL, capacidad VARCHAR(255) NOT NULL, propietario VARCHAR(255) NOT NULL, identificacion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE viaje DROP FOREIGN KEY fk_viaje_usuario');
        $this->addSql('ALTER TABLE viaje DROP estado');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vehiculo');
        $this->addSql('ALTER TABLE viaje ADD estado VARCHAR(50) DEFAULT \'creado\'');
    }
}
