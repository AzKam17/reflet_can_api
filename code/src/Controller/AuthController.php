<?php

namespace App\Controller;

use App\Service\Auth\InscriptionService;
use App\Service\Request\JsonRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function __construct(
        private JsonRequestService $jsonRequestService
    )
    {
    }

    #[Route('/api/inscription', name: 'app_auth')]
    public function inscription(
        Request $request,
        InscriptionService $inscriptionService
    ): JsonResponse
    {
        $data = ($this->jsonRequestService)($request);
        $result = $inscriptionService->createUser(
            nom: $data['nom'],
            email: $data['email'],
            password: $data['password']
        );
        return $this->json(
            data: $result['data'], 
            status: $result['code']
        );
    }
}
