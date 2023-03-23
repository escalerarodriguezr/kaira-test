<?php
declare(strict_types=1);

namespace Kaira\Domain\Shared\Cqrs;

interface CommandBus
{
    public function handle(mixed $command): void;

}
