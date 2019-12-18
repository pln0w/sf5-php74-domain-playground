<?php

declare(strict_types=1);

namespace User\Domain\Security;

use User\Domain\Model\CredentialsHolderInterface;

final class PasswordUpdater implements PasswordUpdaterInterface
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userPasswordEncoder = $passwordEncoder;
    }

    public function updatePassword(CredentialsHolderInterface $user): void
    {
        if ('' !== $user->getPlainPassword()) {
            $user->setPassword($this->userPasswordEncoder->encode($user));
            $user->eraseCredentials();
        }
    }
}
