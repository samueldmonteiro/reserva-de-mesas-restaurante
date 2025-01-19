<?php

namespace App\Controller;

use App\UseCase\Auth\LoginClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class AuthController extends AbstractController
{
    public function __construct(
        private LoginClient $loginClient
    ) {}

    public function loginClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        $result = $this->loginClient->execute($data);

        if ($result->isError()) {
            return $this->json(
                [
                    'error' => true,
                    'message' => $result->getErrorMessage(),
                    'context' => $result->getContext()
                ],
                $result->getStatusCode()
            );
        }

        return $this->json([
            'token' => $result->getValue()
        ]);
    }
}
