<?php

namespace App\Tests\Integration\UseCase\Auth;

use App\Entity\Client;
use App\UseCase\Auth\LoginClient;
use App\UseCase\Client\RegisterClient;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoginClientTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private LoginClient $loginClient;
    private RegisterClient $registerClient;

    private static string $realEmail = 'userTest@email.com';
    private static string $realPassword = '123456';

    public function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();
        $this->loginClient = static::getContainer()->get(LoginClient::class);
        $this->registerClient = static::getContainer()->get(RegisterClient::class);
    }

    public function tearDown(): void
    {
        $this->entityManager->rollback();
        $this->entityManager->close();
        parent::tearDown();
    }

    #[DataProvider('IncorrectLogins')]
    public function testNotGenerateTokenOfIncorrectLogin(string $email, string $password): void
    {
        $this->createClientTest(self::$realEmail,  self::$realPassword);

        $data = (object) ['email' => $email, 'password' => $password];

        $resultLogin = $this->loginClient->execute($data);

        $this->assertTrue($resultLogin->isError());
    }

    public static function IncorrectLogins(): array
    {
        return [
            [self::$realEmail, '122U'],
            ['test@email.com', self::$realPassword],
            ['test2@email.com', 'incorrect'],
            ['', self::$realPassword],
            [self::$realEmail, ''],
            ['', ''],
        ];
    }

    public function testGenerationTokenOfLogin(): void
    {
        $clientTest = $this->createClientTest(self::$realEmail,  self::$realPassword);

        $data = (object) ['email' => $clientTest->getEmail(), 'password' => self::$realPassword];

        $resultLogin = $this->loginClient->execute($data);

        if ($resultLogin->isError()) {
            $this->fail($resultLogin->getErrorMessage() . " context: " . $resultLogin->getContext()['error']);
        }

        $this->assertNotNull($resultLogin->getValue());
        $this->assertIsString($resultLogin->getValue());
    }


    private function createClientTest(string $email, string $password): Client
    {

        $result = $this->registerClient->execute([
            'name' => 'User Test',
            'email' => $email,
            'password' => $password,
            'telphone' => '98999999999'
        ]);

        return $result->getValue()['client'];
    }
}
