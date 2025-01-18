<?php

namespace App\Tests\Unit\UseCase\Client;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\JWTAuthService;
use App\UseCase\Client\RegisterClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class RegisterClientTest extends TestCase
{
    private RegisterClient $registerClient;
    private UserPasswordHasher|MockObject $userPasswordHashserMock;
    private ClientRepository|MockObject $clientRepositoryMock;
    private JWTAuthService|MockObject $JWTAuthServiceMock;

    public function setUp(): void
    {
        $this->clientRepositoryMock = $this->createMock(ClientRepository::class);
        $this->userPasswordHashserMock = $this->createMock(UserPasswordHasher::class);
        $this->JWTAuthServiceMock = $this->createMock(JWTAuthService::class);

        $this->registerClient = new RegisterClient(
            $this->clientRepositoryMock,
            $this->userPasswordHashserMock,
            $this->JWTAuthServiceMock
        );
    }

    private function mockMethods(Client $client): void
    {
        $this->clientRepositoryMock->method('save')->willReturn($client);
        $this->JWTAuthServiceMock->method('createToken')->willReturn('token...');
        $this->userPasswordHashserMock->method('hashPassword')->willReturn('hash0101010');
    }

    private function createClient(array $data): Client
    {
        return new Client($data['name'], $data['email'], $data['password'], $data['telphone']);
    }

    public function testValidateEmptyData()
    {
        $data = [
            'name' => '',
            'email' => 'test@test.com',
            'telphone' => '',
            'password' => '2321'
        ];

        $clientTest = $this->createClient($data);
        $this->mockMethods($clientTest);

        $result = $this->registerClient->execute($data);

        $this->assertTrue($result->isError());
        $this->assertEquals('Preencha todos os campos corretamente!', $result->getErrorMessage());
    }

    public function testValidateEmail()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@testcom',
            'telphone' => 'test',
            'password' => '2321'
        ];

        $clientTest = $this->createClient($data);
        $this->mockMethods($clientTest);

        $result = $this->registerClient->execute($data);

        $this->assertTrue($result->isError());
        $this->assertEquals('O formato do email é inválido', $result->getErrorMessage());
    }

    public function testValidatePassword()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'telphone' => '99999999999',
            'password' => '231'
        ];

        $clientTest = $this->createClient($data);
        $this->mockMethods($clientTest);

        $result = $this->registerClient->execute($data);

        $this->assertTrue($result->isError());
        $this->assertEquals('A Senha precisa conter mais de 4 caracteres', $result->getErrorMessage());
    }

    public function testValidateTelphone()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'telphone' => '9899',
            'password' => '23199'
        ];

        $clientTest = $this->createClient($data);
        $this->mockMethods($clientTest);

        $result = $this->registerClient->execute($data);

        $this->assertTrue($result->isError());
        $this->assertEquals('O formato do telefone é inválido', $result->getErrorMessage());
    }
}
// 119