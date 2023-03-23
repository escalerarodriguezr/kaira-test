<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Cqrs;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\App;
use ReflectionClass;

class ValidatorResolver
{
    public function __invoke(mixed $command, string $type = 'Command'): mixed
    {
        $reflection = new ReflectionClass($command);
        $typeHandler = sprintf('%sValidator', $type);
        $handlerName = str_replace($type, $typeHandler, $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());

        try {
            $validatorHandler = App::make($handlerName);
        }catch (BindingResolutionException $e){
            $validatorHandler = null;
        }

        return $validatorHandler;
    }

}
