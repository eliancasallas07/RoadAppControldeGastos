<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiTestController extends AbstractController
{
    #[Route('/ping', name: 'app_ping', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('pong');
    }
}
