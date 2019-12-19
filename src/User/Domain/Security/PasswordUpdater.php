<?php

declare(strict_types=1);

namespace User\Domain\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use User\Domain\Model\UserInterface;

final class PasswordUpdater implements PasswordUpdaterInterface
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userPasswordEncoder = $passwordEncoder;
    }

    public function updatePassword(UserInterface $user): void
    {
        if ('' !== $user->getPlainPassword() && null !== $user->getPlainPassword()) {
            $user->setPassword(
                $this->userPasswordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword(),
                )
            );
            $user->eraseCredentials();
        }
    }
}
