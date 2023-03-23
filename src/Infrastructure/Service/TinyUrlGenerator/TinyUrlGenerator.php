<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Service\TinyUrlGenerator;

use Illuminate\Support\Facades\Http;
use Kaira\Domain\Url\Model\ShortUrl;
use Kaira\Domain\Url\Model\Value\Url;
use Kaira\Domain\Url\Service\ShortUrlGenerator;

class TinyUrlGenerator implements ShortUrlGenerator
{
    const API_RESOURCE = '%s?url=%s';

    public function __construct(
        private readonly string $createApiEndPoint
    )
    {
    }


    public function generate(Url $url): ShortUrl
    {
        $response = Http::get(sprintf(
            self::API_RESOURCE,
            $this->createApiEndPoint,
            $url->value
        ));

        if($response->status() != 200){
            throw TinyUrlGeneratorException::withUrl($url);
        }

        return new ShortUrl(
            new Url($response->body())
        );
    }

}
