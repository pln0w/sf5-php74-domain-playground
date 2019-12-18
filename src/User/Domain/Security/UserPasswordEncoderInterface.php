<?php

declare(strict_types=1);

namespace User\Domain\Security;

use User\Domain\Model\CredentialsHolderInterface;

interface UserPasswordEncoderInterface
{
    public function encode(CredentialsHolderInterface $user): string;
}
