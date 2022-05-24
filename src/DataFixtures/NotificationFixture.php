<?php

namespace App\DataFixtures;

use App\Entity\Notification;
use App\Domain\ActivityTypeEnum;
use App\DataFixtures\PostFixture;
use App\DataFixtures\UserFixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NotificationFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dog = $this->getReference(UserFixture::USER_REFERENCE);

        for ($i = 0; $i < 5; $i++) {
            $not = (new Notification())
                ->setDog($dog)
                ->setType(ActivityTypeEnum::CREATE_POST)
                ->setContent("This is a test. We'll make this better soon");

            $manager->persist($not);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            PostFixture::class
        ];
    }
}
