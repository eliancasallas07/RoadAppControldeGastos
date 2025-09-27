<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['error' => 'Email y contraseña requeridos'], 400);
        }

        // Buscar usuario por email
        try {
            $user = $em->getRepository(Usuario::class)->findOneBy(['email' => $email]);
        } catch (\Exception $e) {
            // Tabla no disponible: fallback demo para desarrollo
            if ($email === 'demo@example.com' && $password === 'contraseña_demo') {
                $user = new Usuario();
                if (method_exists($user, 'setNombre')) {
                    $user->setNombre('Usuario Demo');
                }
                if (method_exists($user, 'setEmail')) {
                    $user->setEmail('demo@example.com');
                }
            } else {
                return $this->json(['error' => 'Error DB: '.$e->getMessage()], 500);
            }
        }

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Verificar contraseña (fallback simple si no hay password hashed)
        if (method_exists($user, 'getPassword') && $user->getPassword() !== null) {
            if ($user->getPassword() !== $password) {
                return $this->json(['error' => 'Contraseña incorrecta'], 401);
            }
        } else {
            // si user es el demo creado arriba, permitimos contraseña demo
            if (!($email === 'demo@example.com' && $password === 'contraseña_demo')) {
                return $this->json(['error' => 'Contraseña incorrecta'], 401);
            }
        }

        // Si todo bien, retornamos token JWT y datos del usuario
        $issuedAt = time();
        $expiration = $issuedAt + intval($_ENV['JWT_EXPIRATION'] ?? 3600);
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiration,
            'sub' => $user->getId(),
            'email' => $user->getEmail(),
            'nombre' => $user->getNombre(),
            'roles' => method_exists($user, 'getRoles') ? $user->getRoles() : []
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'] ?? 'dev_jwt_secret_change_me', 'HS256');

        return $this->json([
            'token' => $token,
            'usuario' => [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'email' => $user->getEmail()
            ]
        ]);
    }
}
