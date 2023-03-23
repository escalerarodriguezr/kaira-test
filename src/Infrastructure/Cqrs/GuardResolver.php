<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Cqrs;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\App;
use ReflectionClass;

class GuardResolver
{
    public function __invoke(mixed $command, string $type = 'Command'): mixed
    {
        $reflection = new ReflectionClass($command);
        $typeHandler = sprintf('%sGuard', $type);
        $handlerName = str_replace($type, $typeHandler, $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());

        try {
            $guardHandler = App::make($handlerName);
        }catch (BindingResolutionException $e){
            $guardHandler = null;
        }

        return $guardHandler;
    }

}
