<?php
declare(strict_types=1);

namespace Kaira\Application\Url\ShortenUrlUseCase;

class ShortenUrlQuery
{

    public function __construct(
        public readonly string $url
    )
    {
    }
}
