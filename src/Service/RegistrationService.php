<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use App\Entity\Dog;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationService
{
    private DogCRUDService $dogService;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(DogCRUDService $dogService, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->dogService = $dogService;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function handleRegistration(Dog $dog, FormInterface $form): bool
    {
        // is form posted in POST HTTP Response and is the form valid
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $dog->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $dog,
                    $form->get('plainPassword')->getData()
                )
            );
            $dog->setRoles($dog->getRoles());
            $this->dogService->saveDog($dog);
            // do anything else you need here, like send an email

            return true;
        }
        return false;
    }
}
