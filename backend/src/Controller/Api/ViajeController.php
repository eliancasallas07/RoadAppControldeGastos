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
                'fecha' => $v->getFecha() ? $v->getFecha()->format('Y-m-d') : null,
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
        $fecha = $data['fecha'] ?? null; // expect YYYY-MM-DD

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
        if ($fecha) {
            try {
                $viaje->setFecha(new \DateTime($fecha));
            } catch (\Exception $e) {
                // ignore invalid date
            }
        }
        if ($usuario) {
            $viaje->setUsuario($usuario);
        }

        $em->persist($viaje);
        $em->flush();

        return $this->json(['status' => 'ok', 'id' => $viaje->getId()], 201);
    }
}
