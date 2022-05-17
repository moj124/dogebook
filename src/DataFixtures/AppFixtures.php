<?php
namespace App\DataFixtures;

// src/DataFixtures/AppFixtures.php
use App\Entity\Dog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $dog = new Dog();
        // use the repo here......
        $dog->setUsername('testUser');
        $dog->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($dog, 'pass_1234');
        $dog->setPassword($password);

        $manager->persist($dog);
        $manager->flush();
    }
}