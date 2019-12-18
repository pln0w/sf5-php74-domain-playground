<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use Pawly\RestApiValidator\Response\ApiResponse;
use Shared\Infrastructure\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use User\Application\Command\CreateUserCommand;
use User\Application\Query\UserQueryInterface;
use User\Infrastructure\Request\RegisterUserRequest;

final class RegisterUserAction
{
    private CommandBusInterface $commandBus;
    private UserQueryInterface $userQuery;

    public function __construct(CommandBusInterface $commandBus, UserQueryInterface $userQuery)
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
    }

    public function __invoke(RegisterUserRequest $request): ApiResponse
    {
        $this->commandBus->handle(
            new CreateUserCommand($request->getEmail(), $request->getUsername(), $request->getPassword())
        );

        return ApiResponse::json(
            $this->userQuery->findByEmail($request->getEmail()),
            JsonResponse::HTTP_CREATED
        );
    }
}