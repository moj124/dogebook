<?php
namespace App\DataFixtures;

use App\Entity\Dog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public const USER_REFERENCE = 'USER';
    public const ADMIN_REFERENCE = 'ADMIN';

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
        $this->addReference(self::USER_REFERENCE, $dogUser);


        // Admin User
        $dogAdmin = new Dog();
        $dogAdmin->setUsername('testAdmin');
        $dogAdmin->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($dogAdmin, 'pass_1234');
        $dogAdmin->setPassword($password);

        $manager->persist($dogAdmin);
        $this->addReference(self::ADMIN_REFERENCE, $dogAdmin);


        // Friend group
        $dog1 = (new Dog())
            ->setUsername('testUser1')
            ->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword($dog1, 'pass_1234');
        $dog1->setPassword($password);
        $dog1->setPartOfPacks($dogUser);
        $dogUser->setPartOfPacks($dog1);
        $manager->persist($dog1);

        $dog2 = (new Dog())
            ->setUsername('testUser2')
            ->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword($dog2, 'pass_1234');
        $dog2->setPassword($password);
        $dog2->setPartOfPacks($dogUser);
        $dogUser->setPartOfPacks($dog2);
        $manager->persist($dog2);
        
        $manager->flush();
    }
}