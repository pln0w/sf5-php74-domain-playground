<?php
declare(strict_types=1);

namespace User\Application\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class UserProvider implements UserProviderInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        $user = $this->repository->findOneByEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException('User not found');
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;

    }
}