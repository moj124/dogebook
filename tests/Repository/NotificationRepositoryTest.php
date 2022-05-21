<?php

namespace App\Tests\Repository;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationRepositoryTest extends KernelTestCase
{
    private NotificationRepository $notificationsRepo;

    public function setUp(): void
    {
        $this->notificationsRepo = static::getContainer()->get(NotificationRepository::class);    
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

    

    
}