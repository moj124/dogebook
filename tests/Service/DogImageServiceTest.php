<?php

namespace App\Tests\Service;

use App\Service\DogCRUDService;
use App\Service\DogImageService as ServiceDogImageService;
use DogImageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DogImageServiceTest extends KernelTestCase {

    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testSomething(): void
    {
        $imageService = static::getContainer()->get(DogImageService::class);

        $response = $imageService->getRandomDogImageString();
        $response->$this->assertInstanceOf(string::class, get_class($response));
    }
}
