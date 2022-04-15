<?php

namespace App\Command;

use App\Service\DogCRUDService;
use App\Entity\Dog;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeUserAccountCommand extends Command
{
    protected static $defaultName = 'app:make-user-account';
    private DogCRUDService $dogCrudService;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(DogCRUDService $service, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->dogCrudService = $service;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Username for account');
        $this->addOption('type', 't', InputOption::VALUE_REQUIRED, 'User account type');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dog = new Dog();
        $dog->setUsername($input->getOption('username'));
        $dog->setPassword(
            $this->userPasswordHasher->hashPassword(
                $dog,
                'password123'
            )
        );
        
        $role = [];

        if ($input->getOption('type') === 'admin') {
            array_push($role, 'ROLE_ADMIN');
            $dog->setRoles($role);
        }

        if ($input->getOption('type') === 'user') {
            array_push($role, 'ROLE_USER');
            $dog->setRoles($role);
        }

        $this->dogCrudService->saveDog($dog);

        $io->success("Created new Dog user account. Username: {$input->getOption('username')} and password: password123");

        return Command::SUCCESS;
    }
}
