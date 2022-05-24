<?php

namespace App\Tests\Repository;

use App\Repository\DogRepository;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationRepositoryTest extends KernelTestCase
{
    private NotificationRepository $notificationsRepo;
    private DogRepository $dogRepo;

    public function setUp(): void
    {
        self::bootKernel();
        $this->notificationsRepo = static::getContainer()->get(NotificationRepository::class);    
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
    }

    /**
     * This is called a smoke test. It exists to verify that things are working as we expect. Because this 
     * Is a mission critical bit of code (notifications need to work as a key feature of the app)
     * I smoke test this before doing anything else As I want to verify that it is in the service container
     * Smoke tests are code for catching bugs.
     */
    public function testNotificationRepositoryServiceIsAvailable(): void
    {
        $this->assertTrue(
            static::getContainer()->has(NotificationRepository::class),
            true
        );
    }

    /**
     * This is a data provider. This allows us to pass multiples pieces of data into a single test
     * This is really useful when we're trying to test multiple scenarioes for a bit of code under
     * test. This here is a mildly complicated example that uses callback functions to yield data
     * 
     * The idea is that we have dogs that have notifications and dogs without. We want to verify
     * that a dog can get its notifications and that notifications are not returned if they are not applicable.
     */
    public function providesDogsWithNotifications(): array
    {
        return [
            'Dog with notifications' => [
                function () {
                    $this->dogRepo = static::getContainer()->get(DogRepository::class);
                    return $this->dogRepo->findOneBy(['username' => 'testUser']);
                },
                5
            ],
            'Dog without notifications' => [
                function () {
                    $this->dogRepo = static::getContainer()->get(DogRepository::class);
                    return $this->dogRepo->findOneBy(['username' => 'testAdmin']);
                },
                0
            ]
        ];
    }


    /**
     * @dataProvider providesDogsWithNotifications
     */
    public function testCanGetAllDogsNotifications($dogFactory, int $expectedCount): void
    {
        $dog = $dogFactory();

        $notificationsInDBForDog = 
            $this->notificationsRepo->findBy(['dog' => $dog->getId()]);

        $this->assertEquals($expectedCount, count($notificationsInDBForDog));
    }
}