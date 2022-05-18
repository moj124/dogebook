<?php
namespace App\DataFixtures;

// src/DataFixtures/AppFixtures.php
use App\Entity\Dog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        // Normal User
        $dogUser = new Dog();
        $dogUser->setUsername('testUser');
        $dogUser->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($dogUser, 'pass_1234');
        $dogUser->setPassword($password);

        $manager->persist($dogUser);
        $manager->flush();


        // Admin User
        $dogAdmin = new Dog();
        $dogAdmin->setUsername('testAdmin');
        $dogAdmin->setRoles(['ROLE_ADMIN', $dogAdmin]);

        $password = $this->hasher->hashPassword($dogAdmin, 'pass_1234');
        $dogAdmin->setPassword($password);

        $manager->persist($dogAdmin);
        $manager->flush();
    }
}