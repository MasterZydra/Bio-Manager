<?php

declare(strict_types = 1);

namespace Framework\Authentication\Commands;

class MakeUserCommand extends \Framework\Cli\BaseCommand implements \Framework\Cli\CommandInterface
{
    public function execute(array $args): int
    {
        $firstname = $this->input('Firstname:');
        $lastname = $this->input('Lastname:');
        $username = $this->input('Username:');
        $password = $this->input('Password:');

        (new \App\Models\User())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setUsername($username)
            ->setPassword($password)
            ->setIsLocked(false)
            ->setIsPwdChangeForced(false)
            ->save();

        printLn('Created user "' . $username . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:user';
    }

    public function getDescription(): string
    {
        return 'Create a new user';
    }
}