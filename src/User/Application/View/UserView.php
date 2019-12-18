<?php

declare(strict_types=1);

namespace User\Application\View;

use JsonSerializable;

final class UserView implements JsonSerializable
{
    private int $id;
    private string $email;
    private string $username;

    public function __construct(int $id, string $email, string $username)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}