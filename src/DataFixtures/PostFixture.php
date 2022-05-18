<?php
namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dog = $this->getReference(UserFixture::USER_REFERENCE);

        for ($i = 0; $i < 5; $i++) {
            $post = (new Post())
                ->setPostText("Woof woofingtons")
                ->setDog($dog);
            
            $manager->persist($post);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }
}