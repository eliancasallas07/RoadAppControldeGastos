<?php
namespace App\Controller\Api;

use App\Entity\Vehiculo;
use App\Repository\VehiculoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/vehiculos")
 */
class VehiculoController extends AbstractController
{
    private $vehiculoRepository;
    private $em;

    public function __construct(VehiculoRepository $vehiculoRepository, EntityManagerInterface $em)
    {
        $this->vehiculoRepository = $vehiculoRepository;
        $this->em = $em;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $vehiculos = $this->vehiculoRepository->findAll();
        $data = [];
        foreach ($vehiculos as $vehiculo) {
            $data[] = [
                'id' => $vehiculo->getId(),
                'marca' => $vehiculo->getMarca(),
                'modelo' => $vehiculo->getModelo(),
                'placa' => $vehiculo->getPlaca(),
                'descripcion' => $vehiculo->getDescripcion(),
                // Agrega aquí los demás campos que quieras exponer
            ];
        }
        return $this->json($data);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vehiculo = new Vehiculo();
    if (isset($data['marca'])) $vehiculo->setMarca($data['marca']);
    if (isset($data['numeroChasis'])) $vehiculo->setNumeroChasis($data['numeroChasis']);
    if (isset($data['numeroMotor'])) $vehiculo->setNumeroMotor($data['numeroMotor']);
    if (isset($data['cilindrada'])) $vehiculo->setCilindrada($data['cilindrada']);
    if (isset($data['modelo'])) $vehiculo->setModelo($data['modelo']);
    if (isset($data['linea'])) $vehiculo->setLinea($data['linea']);
    if (isset($data['potenciaHp'])) $vehiculo->setPotenciaHp($data['potenciaHp']);
    if (isset($data['declaracionImportacion'])) $vehiculo->setDeclaracionImportacion($data['declaracionImportacion']);
    if (isset($data['fechaImportacion'])) $vehiculo->setFechaImportacion($data['fechaImportacion']);
    if (isset($data['puertas'])) $vehiculo->setPuertas($data['puertas']);
    if (isset($data['fechaMatricula'])) $vehiculo->setFechaMatricula($data['fechaMatricula']);
    if (isset($data['organismoTransito'])) $vehiculo->setOrganismoTransito($data['organismoTransito']);
    if (isset($data['ciudad'])) $vehiculo->setCiudad($data['ciudad']);
    if (isset($data['tipoCarroceria'])) $vehiculo->setTipoCarroceria($data['tipoCarroceria']);
    if (isset($data['combustible'])) $vehiculo->setCombustible($data['combustible']);
    if (isset($data['capacidad'])) $vehiculo->setCapacidad($data['capacidad']);
    if (isset($data['propietario'])) $vehiculo->setPropietario($data['propietario']);
    if (isset($data['identificacion'])) $vehiculo->setIdentificacion($data['identificacion']);
        $this->em->persist($vehiculo);
        $this->em->flush();
        return $this->json(['id' => $vehiculo->getId()], 201);
    }
}
