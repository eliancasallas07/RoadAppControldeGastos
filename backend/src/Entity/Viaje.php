<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ViajeRepository;

#[ORM\Entity(repositoryClass: ViajeRepository::class)]
#[ORM\Table(name: "viaje")]
class Viaje
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"bigint")]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $origen = null;

    #[ORM\Column(length:255)]
    private ?string $destino = null;

    #[ORM\Column(length:255)]
    private ?string $vehiculo = null;

    #[ORM\Column(type:"date")]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: "usuario_id", referencedColumnName: "id", nullable: true, onDelete:"SET NULL")]
    private ?Usuario $usuario = null;

    #[ORM\Column(type:"datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrigen(): ?string
    {
        return $this->origen;
    }

    public function setOrigen(string $origen): static
    {
        $this->origen = $origen;
        return $this;
    }

    public function getDestino(): ?string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): static
    {
        $this->destino = $destino;
        return $this;
    }

    public function getVehiculo(): ?string
    {
        return $this->vehiculo;
    }

    public function setVehiculo(string $vehiculo): static
    {
        $this->vehiculo = $vehiculo;
        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}