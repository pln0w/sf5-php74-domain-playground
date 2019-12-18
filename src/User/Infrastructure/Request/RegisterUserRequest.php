<?php

declare(strict_types=1);

namespace User\Infrastructure\Request;

use Pawly\RestApiValidator\Request\AbstractCustomRequest;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserRequest extends AbstractCustomRequest
{
    protected ?string $email = null;
    protected ?string $username = null;
    protected ?string $password = null;

    /**
     * @inheritDoc
     */
    public function getValidationRules()
    {
        return new Assert\Collection([
            'email' => new Assert\Email(),
            'username' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 6])
            ],
            'password' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 6])
            ]
        ]);
    }
}