<?php

namespace App\Tests\Controller;

use App\Repository\DogRepository;
use App\Service\DogCRUDService;
use App\Service\DogImageService;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private DogRepository $dogRepo;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
    }

    public function testItCanGetTheRegisterFormView(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
        // we could also assert inputs here. Not a big thing, but would make this test more meaningful.
    }

    public function testUsersCanRegister(): void
    {
        $crawler = $this->client->request('GET', '/register');
        
        $registerButton = $crawler->selectButton('Register');
        $form = $registerButton->form([
            'registration_form[username]' => 'test123',
            'registration_form[plainPassword]' => '12345678',
            'registration_form[agreeTerms]' => 1
        ]);

        $this->client->submit($form);
        $newDog = $this->dogRepo->findBy(['username' => 'test123'])[0];
        
        $this->assertTrue($newDog->getUserIdentifier() === 'test123');
    }

    public function testUsersCanLogIn(): void
    {
        // Should be straightforward given that we have fixture data
    }

    // I wouldn't work on other auth stuff tbh. Let's focus on getting a working project!!
}
