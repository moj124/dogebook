<?php

namespace App\Tests\Service;

use App\Service\DogImageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DogImageServiceTest extends KernelTestCase {

    public function setUp(): void
    {
        self::bootKernel();
    }
    
    /**
     * Unmocked tests make more sense when testing most things internal to your app.
     * In the case that you are using an external API though, it is WAY safer to mock.
     * Mocks and stubs should be generally avoided as all they do is make happy noises.
     * They do not throw errors or behave as the class would do normally in the contest you use it. 
     * However, If you know what the results of API calls will be, 
     * you can stub these out and use them in tests. 
     * 
     * The purpose of both mocks and stubs is to give your 
     * app a 'control' dependency that you can test around.
     */
    public function testImageServiceGetsRandomImageStringURL(): void
    {
        $imageService = static::getContainer()->get(DogImageService::class);

        $response = $imageService->getRandomDogImageString();
        $this->assertStringContainsString('https', $response);
    }

    /**
     * This is a stubbed version of the above test. 
     * Stubs are good for cases where returned data is predictable
     * The stub is told how it will be used and what it will return when it is used. 
     * Stubs do not perform any logic and simply return the value they are told to.
     * They are dumb 'in that they only do one thing' and do not check anything. 
     */
    public function testImageServiceGetsRandomImageStringURLStubbed(): void
    {
        /**
         * Instead of getting the service container, we get the class and create stub with it
         * Because the class details the methods and 'shape' of the created object, creating the
         * stub is simple. Introspect on this method and take a look
         */
        $stubbedImageService = $this->createStub(DogImageService::class);

        /**
         * Now that we have our stub, we need to create the method reference. Because the stub object
         * Isn't real, any references to it's members will be empty (initialised to null value)
         * We pass the member we wish to change and what the value should be. In our case, we're changing 
         * a method (9/10 times this will be what you do), so we have to specify the return value
         */
        $stubbedImageService->method('getRandomDogImageString')->willReturn('https://dogs.lookatthese');
        
        /**
         * Now that we've done this, we can use the method as normal and it will behave as if we had
         * Used the actual service. Note that here, we assert the exact value. This is because we had
         * control over it thanks to the stub. This is what stubs are for. Controlling potentially
         * unpredictable external APIs
         */
        $response = $stubbedImageService->getRandomDogImageString();
        $this->assertEquals('https://dogs.lookatthese', $response);
    }
}
