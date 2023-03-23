<?php

namespace Tests\Unit\src\Application\Url\ShortenUrlUseCase;

use Illuminate\Support\Facades\App;
use Kaira\Application\Url\ShortenUrlUseCase\ShortenUrlQuery;
use Kaira\Application\Url\ShortenUrlUseCase\ShortenUrlQueryHandler;
use Kaira\Domain\Url\Model\ShortUrl;
use Kaira\Domain\Url\Model\Value\Url;
use Kaira\Domain\Url\Service\ShortUrlGenerator;
use Mockery\MockInterface;
use Tests\TestCase;

class ShortenUrlQueryHandlerTest extends TestCase
{
    public function testSuccessResponse(): void
    {

        $query = new ShortenUrlQuery('https://laravel.com');
        $sortUrl = new ShortUrl(
            new Url('https://tinyurl.com/ybttxx37')
        );

        $this->mock(ShortUrlGenerator::class, function (MockInterface $mock) use ($query, $sortUrl) {
            $mock->shouldReceive('generate')
                ->once()
                ->withArgs(
                    function (Url $url) use ($query){
                        return $url->value === $query->url;
                    }
                )->andReturn($sortUrl);
        });

        $service = App::make(ShortenUrlQueryHandler::class);

        /**
         * @var ShortUrl $response
         */
        $response = $service->__invoke($query);

        self::assertSame(
            $response->getUrl(),
            $sortUrl->getUrl()->value
        );

    }


}
