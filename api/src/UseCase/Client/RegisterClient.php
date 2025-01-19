<?php

namespace App\UseCase\Client;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\JWTAuthService;
use Samueldmonteiro\Result\Error;
use Samueldmonteiro\Result\Result;
use Samueldmonteiro\Result\Success;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterClient
{
    public function __construct(
        private ClientRepository $clientRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTAuthService $jWTAuthService
    ) {}

    /**
     * @return Result<array>
     */
    public function execute(array $data): Result
    {
        $data = (object) $data;

        $name = trim($data->name ?? null);
        $email = trim($data->email ?? null);
        $password = trim($data->password ?? null);
        $telphone = trim($data->telphone ?? null);

        if (empty($name) || empty($email) || empty($password) || empty($telphone)) {
            return new Error('Preencha todos os campos corretamente!', 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Error('O formato do email é inválido', 400);
        }

        if (!$this->checkTelphone($telphone)) {
            return new Error('O formato do telefone é inválido', 400);
        }

        if (strlen($password) < 4) {
            return new Error('A Senha precisa conter mais de 4 caracteres', 400);
        }

        if ($this->clientRepository->findByEmail($email)) {
            return new Error('Este email já está cadastrado, tente outro', 400);
        }

        $newClient = new Client($name, $email, $password, $telphone);

        $passwordHashed = $this->passwordHasher->hashPassword($newClient, $password);

        $newClient->setPassword($passwordHashed);
        $newClient->setRoles(['IS_CLIENT']);

        try {
            $clientSaved = $this->clientRepository->save($newClient);
        } catch (\Exception $e) {
            return new Error($e->getMessage(), $e->getCode());
        }

        return new Success([
            'client' => $clientSaved,
            'token' => $this->jWTAuthService->createToken($clientSaved)
        ]);
    }

    private function checkTelphone(string $telphone): bool
    {
        $telphoneFormatted = preg_replace('/\D/', '', $telphone);
        return preg_match('/^\d{11}$/', $telphoneFormatted) === 1;
    }
}
