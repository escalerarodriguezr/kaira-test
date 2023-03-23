<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;

interface QueryBus
{
    public function handle(mixed $query): mixed;

}
