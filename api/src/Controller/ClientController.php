<?php

namespace App\Controller;

use App\UseCase\Client\RegisterClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ClientController extends AbstractController
{
    public function __construct(
        private RegisterClient $registerClient
    ) {}

    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $result = $this->registerClient->execute($data);

        if ($result->isError()) {
            return $this->json(['error' => true, 'message' => $result->getErrorMessage()], $result->getStatusCode());
        }

        return $this->json($result->getValue());
    }
}
