<?php

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTAuthService
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager
    ) {}

    public function createToken(UserInterface $user): string
    {
        return $this->jwtManager->create($user);
    }
}
