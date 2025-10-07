<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/usuarios')]
class UsuarioController extends AbstractController
{
    // GET: listar todos los usuarios
    #[Route('', methods: ['GET'])]
    public function index(UsuarioRepository $repo): JsonResponse
    {
        $usuarios = $repo->findAll();
        $data = [];

        foreach ($usuarios as $usuario) {
            $data[] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'email' => $usuario->getEmail()
            ];
        }

        return $this->json($data);
    }

    // POST: crear un usuario
    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuario();
        $usuario->setNombre($data['nombre'] ?? 'Sin nombre');
        $usuario->setEmail($data['email'] ?? 'sinemail@example.com');

        $em->persist($usuario);
        $em->flush();

        return $this->json([
            'status' => 'Usuario creado',
            'id' => $usuario->getId()
        ], 201);
    }
}
