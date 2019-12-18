<?php

declare(strict_types=1);

namespace User\Domain\Security;

use User\Domain\Model\CredentialsHolderInterface;

interface PasswordUpdaterInterface
{
    public function updatePassword(CredentialsHolderInterface $user): void;
}
