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

    #[ORM\Column(length:255)]
    private ?string $conductor = null;

    #[ORM\Column(type:"date")]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: "usuario_id", referencedColumnName: "id", nullable: true, onDelete:"SET NULL")]
    private ?Usuario $usuario = null;

    #[ORM\Column(type:"datetime")]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $valorFlete = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $comision = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $cargueValor = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $descargueValor = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $descarrozar = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $peajes = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $acpm = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $parqueos = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $lavados = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $reparaciones = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $descuentos = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $documentos = null;

    #[ORM\Column(type:"float", nullable:true)]
    private ?float $pesoKilos = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $tipoCarga = null;

    // Getters y setters
    public function getValorFlete(): ?float { return $this->valorFlete; }
    public function setValorFlete(?float $valorFlete): static { $this->valorFlete = $valorFlete; return $this; }

    public function getComision(): ?float { return $this->comision; }
    public function setComision(?float $comision): static { $this->comision = $comision; return $this; }

    public function getCargueValor(): ?float { return $this->cargueValor; }
    public function setCargueValor(?float $cargueValor): static { $this->cargueValor = $cargueValor; return $this; }

    public function getDescargueValor(): ?float { return $this->descargueValor; }
    public function setDescargueValor(?float $descargueValor): static { $this->descargueValor = $descargueValor; return $this; }

    public function getDescarrozar(): ?float { return $this->descarrozar; }
    public function setDescarrozar(?float $descarrozar): static { $this->descarrozar = $descarrozar; return $this; }

    public function getPeajes(): ?float { return $this->peajes; }
    public function setPeajes(?float $peajes): static { $this->peajes = $peajes; return $this; }

    public function getAcpm(): ?float { return $this->acpm; }
    public function setAcpm(?float $acpm): static { $this->acpm = $acpm; return $this; }

    public function getParqueos(): ?float { return $this->parqueos; }
    public function setParqueos(?float $parqueos): static { $this->parqueos = $parqueos; return $this; }

    public function getLavados(): ?float { return $this->lavados; }
    public function setLavados(?float $lavados): static { $this->lavados = $lavados; return $this; }

    public function getReparaciones(): ?float { return $this->reparaciones; }
    public function setReparaciones(?float $reparaciones): static { $this->reparaciones = $reparaciones; return $this; }

    public function getDescuentos(): ?float { return $this->descuentos; }
    public function setDescuentos(?float $descuentos): static { $this->descuentos = $descuentos; return $this; }

    public function getDocumentos(): ?string { return $this->documentos; }
    public function setDocumentos(?string $documentos): static { $this->documentos = $documentos; return $this; }

    public function getPesoKilos(): ?float { return $this->pesoKilos; }
    public function setPesoKilos(?float $pesoKilos): static { $this->pesoKilos = $pesoKilos; return $this; }

    public function getTipoCarga(): ?string { return $this->tipoCarga; }
    public function setTipoCarga(?string $tipoCarga): static { $this->tipoCarga = $tipoCarga; return $this; }

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

    public function getConductor(): ?string
    {
        return $this->conductor;
    }

    public function setConductor(string $conductor): static
    {
        $this->conductor = $conductor;
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