<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;

class QueryValidatorException extends \DomainException
{
    public static function fromQuery(mixed $query, string $argument): self
    {
        return new self(
            sprintf(
                '%s argument is invalid for %s',
                $argument,
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
