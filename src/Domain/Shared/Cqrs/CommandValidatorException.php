<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;

class CommandValidatorException extends \DomainException
{
    public static function fromCommand(mixed $command, string $argument): self
    {
        return new self(
            sprintf(
                '%s argument is invalid for %s',
                $argument,
                self::getSortClassName( $command::class)
            )
        );
    }

    private static function getSortClassName(string $className): string
    {
        $parts = explode('\\', $className);
        return end($parts);
    }


}
