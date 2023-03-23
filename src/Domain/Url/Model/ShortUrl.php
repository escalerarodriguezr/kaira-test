<?php
declare(strict_types=1);

namespace Kaira\Domain\Url\Model;

use Kaira\Domain\Url\Model\Value\Url;

class ShortUrl
{
    public function __construct(
        private readonly Url $url
    )
    {
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

}
