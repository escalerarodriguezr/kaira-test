<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Cqrs\CommandBus;

use Illuminate\Support\Facades\DB;
use Kaira\Domain\Shared\Cqrs\CommandBus;
use Kaira\Infrastructure\Cqrs\GuardResolver;
use Kaira\Infrastructure\Cqrs\HandlerResolver;
use Kaira\Infrastructure\Cqrs\ValidatorResolver;

class InMemoryCommandBus implements CommandBus
{
    public function __construct(
        private readonly HandlerResolver $handlerResolver,
        private readonly GuardResolver $guardResolver,
        private readonly ValidatorResolver $validatorResolver
    )
    {
    }

    public function handle(mixed $command): void
    {
        //Guard
        $guard = $this->guardResolver->__invoke($command);
        if($guard !== null){
            $guard($command);
        }

        //Validator
        $validator = $this->validatorResolver->__invoke($command);
        if($validator !== null){
            $validator($command);
        }

        //Handler
        if (
            !empty(env('DB_CONNECTION', null)) &&
            !app()->environment('testing')
        )
        {
            DB::beginTransaction();
        }

        try {
            $handler = $this->handlerResolver->__invoke($command);
            $handler($command);
            if (
                !empty(env('DB_CONNECTION', null)) &&
                !app()->environment('testing')
            )
            {
                DB::commit();
            }
        } catch (\Throwable $exception) {
            if (
                !empty(env('DB_CONNECTION', null)) &&
                !app()->environment('testing')
            )
            {
                DB::rollBack();
            }
            throw $exception;
        }

    }
}
