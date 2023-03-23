<?php

namespace Tests\Unit\src\Application\Url\ShortenUrlUseCase;

use Kaira\Application\Url\ShortenUrlUseCase\ShortenUrlQuery;
use Kaira\Application\Url\ShortenUrlUseCase\ShortenUrlQueryValidator;
use Kaira\Domain\Shared\Cqrs\QueryValidatorException;
use PHPUnit\Framework\TestCase;

class ShortenUrlQueryValidatorTest extends TestCase
{
    public function testSuccessValidation(): void
    {
        $query = new ShortenUrlQuery('https://laravel.com');
        $validator = new ShortenUrlQueryValidator();
        try{
            $validator->__invoke($query);
        }catch (\Throwable ){
            self::fail();
        }
        self::assertTrue(true);

    }

    public function testQueryValidatorException(): void
    {
        self::expectException(QueryValidatorException::class);
        $query = new ShortenUrlQuery('fake-url');
        $validator = new ShortenUrlQueryValidator();
        $validator->__invoke($query);

    }

}
