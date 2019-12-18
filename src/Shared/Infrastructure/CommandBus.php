<?php

namespace Shared\Infrastructure;

use Shared\Application\CommandInterface;
use Shared\Domain\Exception\HandlerNotFoundException;

final class CommandBus implements CommandBusInterface
{
    private array $handlers;

    public function map(string $command, callable $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    public function handle(CommandInterface $command): void
    {
        $className = \get_class($command);
        $handlerNotFound = false === isset($this->handlers[$className]);
        HandlerNotFoundException::throwWhen($handlerNotFound, $className);

        call_user_func($this->handlers[$className], $command);
    }
}

