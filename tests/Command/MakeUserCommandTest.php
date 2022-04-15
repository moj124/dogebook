<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class MakeUserCommandTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:make-user-account');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--username' => 'Pablo Escobar',
            '--type' => 'user'
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Username: Pablo Escobar', $output);
    }
}
