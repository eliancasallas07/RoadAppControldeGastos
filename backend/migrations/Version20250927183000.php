<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250927183000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key constraint from viaje.usuario_id to user.id';
    }

    public function up(Schema $schema): void
    {
        // add foreign key referencing the `user` table (Usuario entity maps to `user`)
        $this->addSql('ALTER TABLE viaje ADD CONSTRAINT fk_viaje_usuario FOREIGN KEY (usuario_id) REFERENCES `user` (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE viaje DROP FOREIGN KEY fk_viaje_usuario');
    }
}
