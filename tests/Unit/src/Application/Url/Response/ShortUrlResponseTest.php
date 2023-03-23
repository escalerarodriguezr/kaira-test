<?php
declare(strict_types=1);

namespace Tests\Unit\src\Application\Url\Response;

use Kaira\Application\Url\Response\ShortUrlResponse;
use Kaira\Domain\Url\Model\ShortUrl;
use Kaira\Domain\Url\Model\Value\Url;
use PHPUnit\Framework\TestCase;

class ShortUrlResponseTest extends TestCase
{
    public function testCreateFromSortUrl(): void
    {
        $sortUrl = new ShortUrl(
            new Url('https://laravel.com')
        );

        $shortenUrlResponse = ShortUrlResponse::createFromSortUrl($sortUrl);

        self::assertSame(
            $sortUrl->getUrl()->value,
            $shortenUrlResponse->getUrl()
        );

        $toArrayResponse = $shortenUrlResponse->toArray();
        self::assertSame(
            $sortUrl->getUrl()->value,
            $toArrayResponse[ShortUrlResponse::URL]
        );

    }


}
