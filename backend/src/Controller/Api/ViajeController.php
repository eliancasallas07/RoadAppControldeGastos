<?php

namespace App\Controller\Api;

use App\Entity\Viaje;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/viajes')]
class ViajeController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(EntityManagerInterface $em, Request $request): JsonResponse
    {
        // opcional: filtrar por usuario autenticado si Authorization header presente
        $auth = $request->headers->get('Authorization');
        $userId = null;

        if ($auth && str_starts_with($auth, 'Bearer ')) {
            $token = substr($auth, 7);
            try {
                $payload = JWT::decode($token, new Key($_ENV['JWT_SECRET'] ?? 'dev_jwt_secret_change_me', 'HS256'));
                $userId = $payload->sub ?? null;
            } catch (\Exception $e) {
                // si token inválido, ignoramos y devolvemos todos
            }
        }

        if ($userId) {
            $viajes = $em->getRepository(Viaje::class)->findBy(['usuario' => $userId], ['createdAt' => 'DESC']);
        } else {
            $viajes = $em->getRepository(Viaje::class)->findBy([], ['createdAt' => 'DESC']);
        }

        $data = [];
        foreach ($viajes as $v) {
            $data[] = [
                'id' => $v->getId(),
                'origen' => $v->getOrigen(),
                'destino' => $v->getDestino(),
                'vehiculo' => $v->getVehiculo(),
                'conductor' => $v->getConductor(),
                'fecha' => $v->getFecha() ? $v->getFecha()->format('Y-m-d') : null,
                'valorFlete' => $v->getValorFlete(),
                'comision' => $v->getComision(),
                'cargueValor' => $v->getCargueValor(),
                'descargueValor' => $v->getDescargueValor(),
                'descarrozar' => $v->getDescarrozar(),
                'peajes' => $v->getPeajes(),
                'acpm' => $v->getAcpm(),
                'parqueos' => $v->getParqueos(),
                'lavados' => $v->getLavados(),
                'reparaciones' => $v->getReparaciones(),
                'descuentos' => $v->getDescuentos(),
                'documentos' => $v->getDocumentos(),
                'pesoKilos' => $v->getPesoKilos(),
                'tipoCarga' => $v->getTipoCarga(),
                'usuario' => $v->getUsuario() ? ['id' => $v->getUsuario()->getId(), 'nombre' => $v->getUsuario()->getNombre()] : null,
                'createdAt' => $v->getCreatedAt()->format(DATE_ATOM)
            ];
        }
        return $this->json($data);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $origen = $data['origen'] ?? null;
        $destino = $data['destino'] ?? null;
        $vehiculo = $data['vehiculo'] ?? null;
        $conductor = $data['conductor'] ?? null;
        $fecha = $data['fecha'] ?? null;
        $valorFlete = $data['valorFlete'] ?? null;
        $comision = $data['comision'] ?? null;
        $cargueValor = $data['cargueValor'] ?? null;
        $descargueValor = $data['descargueValor'] ?? null;
        $descarrozar = $data['descarrozar'] ?? null;
        $peajes = $data['peajes'] ?? null;
        $acpm = $data['acpm'] ?? null;
        $parqueos = $data['parqueos'] ?? null;
        $lavados = $data['lavados'] ?? null;
        $reparaciones = $data['reparaciones'] ?? null;
        $descuentos = $data['descuentos'] ?? null;
        $documentos = $data['documentos'] ?? null;
        $pesoKilos = $data['pesoKilos'] ?? null;
        $tipoCarga = $data['tipoCarga'] ?? null;

        if (!$fecha) {
            return $this->json(['error' => "El campo 'fecha' es obligatorio"], 400);
        }

        // intentar obtener usuario desde token
        $auth = $request->headers->get('Authorization');
        $usuario = null;
        if ($auth && str_starts_with($auth, 'Bearer ')) {
            $token = substr($auth, 7);
            try {
                $payload = JWT::decode($token, new Key($_ENV['JWT_SECRET'] ?? 'dev_jwt_secret_change_me', 'HS256'));
                $userId = $payload->sub ?? null;
                if ($userId) {
                    $usuario = $em->getRepository(Usuario::class)->find($userId);
                }
            } catch (\Exception $e) {
                // token inválido -> seguir sin usuario
            }
        }

        $viaje = new Viaje();
        $viaje->setOrigen($origen ?? '');
        $viaje->setDestino($destino ?? '');
        $viaje->setVehiculo($vehiculo ?? '');
        $viaje->setConductor($conductor ?? '');
        try {
            $fechaObj = new \DateTime($fecha);
            $viaje->setFecha($fechaObj);
        } catch (\Exception $e) {
            return $this->json(['error' => "El campo 'fecha' tiene un formato inválido"], 400);
        }
        $viaje->setValorFlete($valorFlete);
        $viaje->setComision($comision);
        $viaje->setCargueValor($cargueValor);
        $viaje->setDescargueValor($descargueValor);
        $viaje->setDescarrozar($descarrozar);
        $viaje->setPeajes($peajes);
        $viaje->setAcpm($acpm);
        $viaje->setParqueos($parqueos);
        $viaje->setLavados($lavados);
        $viaje->setReparaciones($reparaciones);
        $viaje->setDescuentos($descuentos);
        $viaje->setDocumentos($documentos);
        $viaje->setPesoKilos($pesoKilos);
        $viaje->setTipoCarga($tipoCarga);
        if ($usuario) {
            $viaje->setUsuario($usuario);
        }

        $em->persist($viaje);
        $em->flush();

        return $this->json(['status' => 'ok', 'id' => $viaje->getId()], 201);
    }
    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $viaje = $em->getRepository(Viaje::class)->find($id);
        if (!$viaje) {
            return $this->json(['error' => 'Viaje no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['origen'])) {
            $viaje->setOrigen($data['origen']);
        }
        if (isset($data['destino'])) {
            $viaje->setDestino($data['destino']);
        }
        if (isset($data['vehiculo'])) {
            $viaje->setVehiculo($data['vehiculo']);
        }
        if (isset($data['fecha'])) {
            try {
                $viaje->setFecha(new \DateTime($data['fecha']));
            } catch (\Exception $e) {
                // fecha inválida, ignorar
            }
        }

        $em->persist($viaje);
        $em->flush();

        return $this->json(['status' => 'ok', 'id' => $viaje->getId()]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $viaje = $em->getRepository(Viaje::class)->find($id);
        if (!$viaje) {
            return $this->json(['error' => 'Viaje no encontrado'], 404);
        }
        $em->remove($viaje);
        $em->flush();
        return $this->json(['status' => 'ok']);
    }
}
