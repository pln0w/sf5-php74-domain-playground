<?php
declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Model\UserInterface;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?UserInterface;

    public function add(UserInterface $user): void;
}
