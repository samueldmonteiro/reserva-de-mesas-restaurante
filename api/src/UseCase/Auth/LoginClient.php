<?php

namespace App\UseCase\Auth;

use App\Repository\ClientRepository;
use App\Service\JWTAuthService;
use Samueldmonteiro\Result\{Result, Error, Success};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginClient
{
    public function __construct(
        private ClientRepository $clientRepository,
        private UserPasswordHasherInterface $hasher,
        private JWTAuthService $JWTAuthService
    ) {}

    /**
     * @return Result<string> token jwt
     */
    public function execute(object $data): Result
    {
        $email = trim($data->email ?? null);
        $password = trim($data->password ?? null);

        if (empty($email) || empty($password)) {
            return new Error('Preencha todos os campos corretamente!', 400);
        }

        if (strlen($password) < 4) {
            return new Error('Login Incorreto, tente novamente', 401);
        }

        $client = $this->clientRepository->findByEmail($email);

        if (!$client) {
            return new Error('Login Incorreto, tente novamente', 401, context: ['error' => 'Email não existe']);
        }

        if (!$this->hasher->isPasswordValid($client, $password)) {
            return new Error('Login Incorreto, tente novamente', 401, null, ['error' => 'Senha incorreta']);
        }

        return new Success($this->JWTAuthService->createToken($client));
    }
}
