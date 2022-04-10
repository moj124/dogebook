<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DogImageService {
    const DOG_API_URL = 'https://dog.ceo/api/breeds/image/random';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    public function getRandomDogImageString(): string
    {
        $response = $this->client->request(
            'GET',
            self::DOG_API_URL
        );

        return $response->toArray()['message'];
    }
}