<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;


class CommandGuardException extends \DomainException
{
    public static function fromCommand(mixed $command): self
    {
        return new self(
            sprintf(
                '%s not allowed',
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
