<?php

namespace App\Service;

use App\Domain\Facade\Cache;
use Lagdo\Symfony\Facades\Log;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DogImageService
{
    const DOG_API_URL = 'https://dog.ceo/api/breeds/image/random';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    /**
     * This is an example of caching. The whole point of caching is to ensure that we don't constantly
     * redo computationaly expensive work. In the case below, we're hitting an external API for an image
     * This isn't that bad really, but for someone with a slow connection, they could be waiting seconds to
     * download the image. By caching the value, we make it so the server returns the cached value instantly.
     */
    public function getRandomDogImageString(): string
    {
        return Cache::get('dogImage', function (ItemInterface $item) {
            $response = $this->client->request(
                'GET',
                self::DOG_API_URL
            );
    
            Log::info('DogImageService@GetRandomDogImageString response from api', [
                'response' => $response->toArray()
            ]);

            $cachedImage = $item->set($response->toArray()['message'])
                ->expiresAfter(180);

            return $cachedImage->get();
        });
    }
}
