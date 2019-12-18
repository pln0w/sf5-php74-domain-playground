<?php

declare(strict_types=1);

namespace User\Infrastructure\DBAL;

use Doctrine\DBAL\Connection;
use User\Application\Query\UserQueryInterface;
use User\Application\View\UserView;

class DoctrineDbalUserQuery implements UserQueryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findByEmail(string $email): UserView
    {
        $user = $this->connection->fetchAssoc('SELECT * FROM users WHERE email = ?', [$email]);

        return new UserView((int) $user['id'], $user['username'], $user['email']);
    }
}