<?php
declare(strict_types=1);

namespace User\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use User\Domain\Model\User;
use User\Domain\Model\UserInterface;
use User\Domain\Repository\UserRepositoryInterface;

final class DoctrineOrmUserRepository extends EntityRepository implements UserRepositoryInterface
{
//    private EntityManagerInterface $em;
//
//    public function __construct(EntityManagerInterface $em)
//    {
//        $this->em = $em;
//    }

    public function findOneByEmail(string $email): ?UserInterface
    {
        return $this->findOneBy(['email' => $email]);
//        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function add(UserInterface $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}