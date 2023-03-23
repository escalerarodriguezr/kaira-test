<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kaira\Domain\Shared\Cqrs\CommandBus;
use Kaira\Domain\Shared\Cqrs\QueryBus;
use Kaira\Domain\Url\Service\ShortUrlGenerator;
use Kaira\Infrastructure\Cqrs\CommandBus\InMemoryCommandBus;
use Kaira\Infrastructure\Cqrs\QueryBus\InMemoryQueryBus;
use Kaira\Infrastructure\Service\TinyUrlGenerator\TinyUrlGenerator;
use Kaira\Infrastructure\Ui\Security\AccessTokenValidator;

class InfrastructureProvider extends ServiceProvider
{
    public function register(): void
    {
        //Cqrs
        $this->app->bind(CommandBus::class, InMemoryCommandBus::class);
        $this->app->bind(QueryBus::class, InMemoryQueryBus::class);

        //Security
        $this->app->when(AccessTokenValidator::class)
            ->needs('$validCharacters')
            ->giveConfig('validate-auth-token.valid-characters');
        $this->app->when(AccessTokenValidator::class)
            ->needs('$validOpenedCharacters')
            ->giveConfig('validate-auth-token.valid-opened-characters');
        $this->app->when(AccessTokenValidator::class)
            ->needs('$validClosedCharacters')
            ->giveConfig('validate-auth-token.valid-closed-characters');

        //TinyUrlGenerator
        $this->app->when(TinyUrlGenerator::class)
            ->needs('$createApiEndPoint')
            ->giveConfig('infrastructure-services-config.tiny-url-generator.create-api-end-point');

        //Services
        $this->app->bind(ShortUrlGenerator::class, TinyUrlGenerator::class);

    }

    public function boot(): void
    {

    }

}
