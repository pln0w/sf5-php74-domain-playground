<?php
declare(strict_types=1);

namespace User\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use User\Domain\Model\UserInterface;
use User\Domain\Repository\UserRepositoryInterface;

class DoctrineOrmUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByEmail(string $email): ?UserInterface
    {
        return $this->em->findOneBy(['email' => $email]);
    }

    public function add(UserInterface $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}