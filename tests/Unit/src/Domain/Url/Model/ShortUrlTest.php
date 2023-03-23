<?php
declare(strict_types=1);

namespace Tests\Unit\src\Domain\Url\Model;

use Kaira\Domain\Url\Model\ShortUrl;
use Kaira\Domain\Url\Model\Value\Url;
use PHPUnit\Framework\TestCase;

class ShortUrlTest extends TestCase
{
    public function testSuccessConstruct(): void
    {
        $url = new Url('https://laravel.com');

        $sortUrl = new ShortUrl($url);
        self::assertSame(
            $url,
            $sortUrl->getUrl()
        );
    }

}
