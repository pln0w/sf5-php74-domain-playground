<?php

declare(strict_types=1);

namespace User\Domain\Security;

use User\Domain\Model\UserInterface;

interface PasswordUpdaterInterface
{
    public function updatePassword(UserInterface $user): void;
}
