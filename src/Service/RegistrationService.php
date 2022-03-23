<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use App\Entity\Dog;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationService
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private DogCRUDService $dogService;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, DogCRUDService $dogService)
    {
        $this->UserPasswordHasher = $userPasswordHasher;
        $this->dogService = $dogService;
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

            $this->dogService->saveDog($dog);
            // do anything else you need here, like send an email

            return true;
        }
        return false;
    }
}
