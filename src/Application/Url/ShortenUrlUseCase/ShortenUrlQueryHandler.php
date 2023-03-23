<?php
declare(strict_types=1);

namespace Kaira\Application\Url\ShortenUrlUseCase;

use Kaira\Application\Url\Response\ShortUrlResponse;
use Kaira\Domain\Url\Model\Value\Url;
use Kaira\Domain\Url\Service\ShortUrlGenerator;

class ShortenUrlQueryHandler
{

    public function __construct(
        private readonly ShortUrlGenerator $sortUrlGenerator
    )
    {
    }

    public function __invoke(ShortenUrlQuery $query): ShortUrlResponse
    {

        $sortUrl = $this->sortUrlGenerator->generate(
            new Url($query->url)
        );

        return ShortUrlResponse::createFromSortUrl($sortUrl);

    }

}
