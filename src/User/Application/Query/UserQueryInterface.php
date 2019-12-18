<?php

declare(strict_types=1);

namespace User\Application\Query;

use Shared\Application\QueryInterface;
use User\Application\View\UserView;

interface UserQueryInterface
{
    public function findByEmail(string $email): UserView;
}