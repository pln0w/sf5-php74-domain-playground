<?php

declare(strict_types=1);

namespace Resources\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use User\Domain\Model\User;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername(sprintf('test%d', $i));
            $user->setEmail(sprintf('test%d@example.com', $i));
            $user->setPlainPassword('secret');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
