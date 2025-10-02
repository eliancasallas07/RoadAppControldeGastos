<?php

namespace App\Entity;

use App\Repository\VehiculoRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ApiResource]
#[ORM\Entity(repositoryClass: VehiculoRepository::class)]
class Vehiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $marca = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroChasis = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroMotor = null;

    #[ORM\Column(length: 255)]
    private ?string $cilindrada = null;

    #[ORM\Column(length: 255)]
    private ?string $modelo = null;

    #[ORM\Column(length: 255)]
    private ?string $linea = null;

    #[ORM\Column(length: 255)]
    private ?string $potenciaHp = null;

    #[ORM\Column(length: 255)]
    private ?string $declaracionImportacion = null;

    #[ORM\Column(length: 255)]
    private ?string $fechaImportacion = null;

    #[ORM\Column(length: 255)]
    private ?string $puertas = null;

    #[ORM\Column(length: 255)]
    private ?string $fechaMatricula = null;

    #[ORM\Column(length: 255)]
    private ?string $organismoTransito = null;

    #[ORM\Column(length: 255)]
    private ?string $ciudad = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoCarroceria = null;

    #[ORM\Column(length: 255)]
    private ?string $combustible = null;

    #[ORM\Column(length: 255)]
    private ?string $capacidad = null;

    #[ORM\Column(length: 255)]
    private ?string $propietario = null;

    #[ORM\Column(length: 255)]
    private ?string $identificacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): static
    {
        $this->marca = $marca;

        return $this;
    }

    public function getNumeroChasis(): ?string
    {
        return $this->numeroChasis;
    }

    public function setNumeroChasis(string $numeroChasis): static
    {
        $this->numeroChasis = $numeroChasis;

        return $this;
    }

    public function getNumeroMotor(): ?string
    {
        return $this->numeroMotor;
    }

    public function setNumeroMotor(string $numeroMotor): static
    {
        $this->numeroMotor = $numeroMotor;

        return $this;
    }

    public function getCilindrada(): ?string
    {
        return $this->cilindrada;
    }

    public function setCilindrada(string $cilindrada): static
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getLinea(): ?string
    {
        return $this->linea;
    }

    public function setLinea(string $linea): static
    {
        $this->linea = $linea;

        return $this;
    }

    public function getPotenciaHp(): ?string
    {
        return $this->potenciaHp;
    }

    public function setPotenciaHp(string $potenciaHp): static
    {
        $this->potenciaHp = $potenciaHp;

        return $this;
    }

    public function getDeclaracionImportacion(): ?string
    {
        return $this->declaracionImportacion;
    }

    public function setDeclaracionImportacion(string $declaracionImportacion): static
    {
        $this->declaracionImportacion = $declaracionImportacion;

        return $this;
    }

    public function getFechaImportacion(): ?string
    {
        return $this->fechaImportacion;
    }

    public function setFechaImportacion(string $fechaImportacion): static
    {
        $this->fechaImportacion = $fechaImportacion;

        return $this;
    }

    public function getPuertas(): ?string
    {
        return $this->puertas;
    }

    public function setPuertas(string $puertas): static
    {
        $this->puertas = $puertas;

        return $this;
    }

    public function getFechaMatricula(): ?string
    {
        return $this->fechaMatricula;
    }

    public function setFechaMatricula(string $fechaMatricula): static
    {
        $this->fechaMatricula = $fechaMatricula;

        return $this;
    }

    public function getOrganismoTransito(): ?string
    {
        return $this->organismoTransito;
    }

    public function setOrganismoTransito(string $organismoTransito): static
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getTipoCarroceria(): ?string
    {
        return $this->tipoCarroceria;
    }

    public function setTipoCarroceria(string $tipoCarroceria): static
    {
        $this->tipoCarroceria = $tipoCarroceria;

        return $this;
    }

    public function getCombustible(): ?string
    {
        return $this->combustible;
    }

    public function setCombustible(string $combustible): static
    {
        $this->combustible = $combustible;

        return $this;
    }

    public function getCapacidad(): ?string
    {
        return $this->capacidad;
    }

    public function setCapacidad(string $capacidad): static
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getPropietario(): ?string
    {
        return $this->propietario;
    }

    public function setPropietario(string $propietario): static
    {
        $this->propietario = $propietario;

        return $this;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): static
    {
        $this->identificacion = $identificacion;

        return $this;
    }
}
