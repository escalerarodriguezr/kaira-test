<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;

class QueryGuardException extends \DomainException
{
    public static function fromQuery(mixed $query): self
    {
        return new self(
            sprintf(
                '%s not allowed',
                self::getSortClassName( $query::class)
            )
        );
    }

    private static function getSortClassName(string $className): string
    {
        $parts = explode('\\', $className);
        return end($parts);
    }


}
