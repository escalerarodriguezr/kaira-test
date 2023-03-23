<?php
declare(strict_types=1);

namespace Tests\Unit\src\Domain\Url\Model\Value;

use Kaira\Domain\Url\Model\Value\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testSuccessConstruct(): void
    {
        $url = new Url('https://laravel.com');
        self::assertSame(
            'https://laravel.com',
            $url->value
        );
    }

    public function testConstructDomainException(): void
    {
        self::expectException(\DomainException::class);
        new Url('fake-url');

    }

}
