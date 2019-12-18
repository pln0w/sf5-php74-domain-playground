<?php

namespace Shared\Domain\Exception;

class HandlerNotFoundException extends \Exception
{
    /** @return self|null */
    public static function throwWhen(bool $condition, string $handlerClassName)
    {
        if (false === $condition) {
            return;
        }

        throw new self(sprintf('Handler %s not found', $handlerClassName));
    }
}