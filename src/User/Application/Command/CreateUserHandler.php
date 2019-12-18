<?php

declare(strict_types=1);

namespace User\Application\Command;

use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

final class CreateUserHandler
{
    private UserRepositoryInterface $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $user->setUsername($command->getUsername());
        $user->setPlainPassword($command->getPassword());

        $this->users->add($user);
    }
}