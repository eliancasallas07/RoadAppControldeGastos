<?php
namespace App\Controller;

use App\Entity\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        ManagerRegistry $doctrine
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['error' => 'Email y contraseña requeridos'], 400);
        }

        // Buscar usuario en la base de datos
        try {
            $usuario = $doctrine->getRepository(Usuario::class)->findOneBy(['email' => $email]);
        } catch (\Exception $e) {
            // En entornos de desarrollo puede que la tabla no exista todavía.
            // Para facilitar pruebas locales, soportamos un usuario demo hardcodeado.
            // IMPORTANTE: esto es solo para desarrollo. Remover en producción.
            if ($email === 'demo@example.com' && $password === 'contraseña_demo') {
                // crear objeto usuario sencillo (sin persistir)
                $usuario = new Usuario();
                // intentar setear campos si existen los setters
                if (method_exists($usuario, 'setNombre')) {
                    $usuario->setNombre('Usuario Demo');
                }
                if (method_exists($usuario, 'setEmail')) {
                    $usuario->setEmail('demo@example.com');
                }
                // algunas entidades requieren roles
                if (method_exists($usuario, 'setRoles')) {
                    $usuario->setRoles(['ROLE_USER']);
                }
            } else {
                return $this->json(['error' => 'Error al acceder a la base de datos: '.$e->getMessage()], 500);
            }
        }

        if (!$usuario || !$passwordHasher->isPasswordValid($usuario, $password)) {
            // si el usuario fue creado como demo (objeto sin password), comprobamos aparte
            if ($email === 'demo@example.com' && $password === 'contraseña_demo') {
                // permitir login demo
            } else {
                return $this->json(['error' => 'Credenciales inválidas'], 401);
            }
        }

        // Generar JWT
        $issuedAt = time();
        $expiration = $issuedAt + intval($_ENV['JWT_EXPIRATION']); // segundos
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiration,
            'sub' => $usuario->getId(),
            'email' => $usuario->getEmail(),
            'nombre' => $usuario->getNombre(),
            'roles' => $usuario->getRoles()
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

        return $this->json([
            'token' => $token,
            'usuario' => [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'email' => $usuario->getEmail(),
                'roles' => $usuario->getRoles()
            ]
        ]);
    }
}
