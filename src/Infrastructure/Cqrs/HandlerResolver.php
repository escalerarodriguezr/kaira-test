<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Cqrs;

use Illuminate\Support\Facades\App;
use ReflectionClass;

class HandlerResolver
{
    public function __invoke(mixed $command, string $type = 'Command'): mixed
    {
        $reflection = new ReflectionClass($command);
        $typeHandler = sprintf('%sHandler', $type);
        $handlerName = str_replace($type, $typeHandler, $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        return App::make($handlerName);
    }

}
