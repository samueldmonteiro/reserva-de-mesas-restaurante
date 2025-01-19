<?php

namespace App\Tests\Integration\UseCase\Client;

use App\Entity\Client;
use App\UseCase\Client\RegisterClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterClientTest extends KernelTestCase
{
    private RegisterClient $registerClient;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();

        $this->registerClient = self::getContainer()->get(RegisterClient::class);
    }

    public function tearDown(): void
    {
        $this->entityManager->rollback();
        $this->entityManager->close();
        parent::tearDown();
    }

    public function testRegisterClient(): void
    {
        $data = [
            'name' => 'userTest',
            'email' => 'test@email.com' . random_int(1, 100),
            'telphone' => '98999999999',
            'password' => '2232'
        ];

        $result = $this->registerClient->execute($data);

        if ($result->isError()) {
            $this->fail($result->getErrorMessage());
        }

        /** @var Client $client */
        $client = $result->getValue()['client'];
        $token = $result->getValue()['token'];

        $this->assertNotNull($token);
        $this->assertNotNull($client);
        $this->assertIsInt($client->getId());
        $this->assertEquals($data['name'], $client->getName());
        $this->assertEquals($data['email'], $client->getEmail());
        $this->assertNotEquals($data['password'], $client->getPassword());
    }
}
