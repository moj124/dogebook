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

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->UserPasswordHasher = $userPasswordHasher;
    }

    public function handleRegistration(Dog $dog, FormInterface $form, DogCRUDService $service) : void
    {
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $dog->setPassword(
            $this->userPasswordHasher->hashPassword(
                    $dog,
                    $form->get('plainPassword')->getData()
                )
            );

            $service->saveDog($dog);
            // do anything else you need here, like send an email
        }
    }
}