<?php

namespace App\Tests\Repository;

use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DogRepositoryTest extends KernelTestCase
{
    private DogRepository $dogRepo;

    public function setUp(): void
    {
        self::bootKernel(); 
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
    }

    public function providesDogsWithFriends(): array
    {
        return [
            'Dog with 2 friends' => [
                function () {
                    $this->dogRepo = static::getContainer()->get(DogRepository::class);
                    return $this->dogRepo->findOneBy(['username' => 'testUser']);
                },
                2
            ],
            'Dog with 1 friend' => [
                function () {
                    $this->dogRepo = static::getContainer()->get(DogRepository::class);
                    return $this->dogRepo->findOneBy(['username' => 'testUser1']);
                },
                1
            ],
            'Dog with no friends :(' => [
                function () {
                    $this->dogRepo = static::getContainer()->get(DogRepository::class);
                    return $this->dogRepo->findOneBy(['username' => 'testAdmin']);
                },
                0
            ],
        ];
    }

    /**
     * @dataProvider providesDogsWithFriends
     */
    public function testCanGetADogsPack($dogFactory, int $friendCount)
    {
        $dog = $dogFactory();

        $this->assertEquals(
            count($this->dogRepo->getDogsPack($dog)),
            $friendCount
        );
    }

    /**
     * @dataProvider providesDogsWithFriends
     */
    public function testItCanGetPacksADogIsIn($dogFactory, int $packsInCount)
    {
        $dog = $dogFactory();

        $this->assertEquals(
            count($this->dogRepo->getPacksDogIsIn($dog)),
            $packsInCount
        );
    }
}