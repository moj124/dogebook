<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\DogImageService;

class HomeControllerTest extends WebTestCase
{
    public function testGETHomeLandingPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'welcome to dogebook');
    }

    /**
     * This is the mocked version of the test in DogImageServiceTest
     * Mocks are designed to test cooperation (Kinda useless if you code the logic out correctly)
     * between components in your system without changing anything about them.
     * We mock when we have external dependencies that change state when we use them, whether in 
     * test or not (3rd party APIs, databases/ datastores etc). In the case below, this is a good way
     * to not bombard the 3rd party API and still confirm e have the correct functionality in our controller
     *  
     */
    public function testImageServiceGetsRandomImageStringURLMocked(): void
    {
        $client = static::createClient();

        /**
         * As with the stubbed version, we need to create the mock. Under the hood, funnily enough, mocks
         * and stubs are basically the same introspect on the method createMock to prove it.
         */
        $mockedImageService = $this->createMock(DogImageService::class);

        /**
         * The difference between mocks and stubs is in their configuration. A mock is designed to detect
         * method calls on the mock object. So, we need to tell it the following:
         * - How many times the method will be called (this will be checked in the test)
         * - What arguments it expects
         * 
         * Note that we do not specify return types here. That is what stubs are for. You can use these
         * in conjunction, though I'd only recommend it in specific circumstances. It's better to separate
         * out mock and stub tests.
         */
        $mockedImageService->expects($this->once())
            ->method('getRandomDogImageString')
            ->with();


        /**
         * FInally, the most opaque bit of mocks, you have to invoke the thing you are mocking in the context
         * in which you'd use it. Because the controller action for the GET '/' route invokes the DogImageService
         * We can see that this test passes. Note that I am not looking for the return value in this test.
         * Mocks often return garbage data
         */
        $client->request('GET', '/');
    }
}
