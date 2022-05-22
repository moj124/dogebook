<?php

namespace App\Tests\Service;

use Carbon\Carbon;
use App\Message\BaseEvent;
use App\Domain\Facade\Cache;
use App\Service\PackService;
use Lagdo\Symfony\Facades\Log;
use App\Repository\DogRepository;
use Symfony\Component\Messenger\Envelope;
use App\MessageHandler\ActivityEventHandler;
use App\Message\ActivityEvents\FriendAddedEvent;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PackServiceTest extends KernelTestCase
{
    private PackService $packService;
    private DogRepository $dogRepo;

    public function setUp(): void
    {
        self::bootKernel();
        $this->packService = static::getContainer()->get(PackService::class);
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
    }

    public function testItCanAddDogsToAPack()
    {
        $dog1 = $this->dogRepo->findOneBy(['username' => 'testUser1']);
        $dog2 = $this->dogRepo->findOneBy(['username' => 'testUser2']);

        $this->packService->addDogToPack($dog1, $dog2);
        $this->assertEquals(
            $this->dogRepo->getDogsPack($dog1),
            $this->dogRepo->getPacksDogIsIn($dog1)
        );
    }


    public function testItAddsPackResultsToCacheAndBustsOnAnyChanges()
    {
        $dog1 = $this->dogRepo->findOneBy(['username' => 'testAdmin']);
        $dog2 = $this->dogRepo->findOneBy(['username' => 'testUser2']);

        $resultPreCache = $this->packService->getPack($dog1);
        $this->assertEquals(0, count($resultPreCache));
        $this->assertEquals(0, count(Cache::getItem(PackService::PACK_IDENTIFIER . $dog1->getId())->get()));

        $this->packService->addDogToPack($dog1, $dog2);
        $resultPostCacheBreak = $this->packService->getPack($dog1);
        $this->assertEquals(1, count($resultPostCacheBreak));
        $this->assertEquals(1, count(Cache::getItem(PackService::PACK_IDENTIFIER . $dog1->getId())->get()));
    }
}