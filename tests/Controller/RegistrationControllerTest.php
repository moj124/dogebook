<?php

namespace App\Tests\Controller;

use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testItCanGetTheRegisterFormView(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testItCanSubmitAndCreateAUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $dogRepo = static::getContainer()->get(DogRepository::class);
        
        $registerButton = $crawler->selectButton('Register');
        $form = $registerButton->form([
            'registration_form[username]' => 'test123',
            'registration_form[plainPassword]' => '12345678',
            'registration_form[agreeTerms]' => 1
        ]);

        $crawler = $client->submit($form);
        $newDog = $dogRepo->findBy(['username' => 'test123'])[0];
        
        $this->assertTrue($newDog->getUserIdentifier() === 'test123');
        $client->followRedirects(true);
    }
}
