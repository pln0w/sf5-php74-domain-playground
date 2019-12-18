<?php

declare(strict_types=1);

namespace User\Application\Command;

use Shared\Application\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    private string $email;
    private string $username;
    private string $password;

    public function __construct(string $email, string $username, string $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
    public function getPassword(): string { return $this->password; }
}