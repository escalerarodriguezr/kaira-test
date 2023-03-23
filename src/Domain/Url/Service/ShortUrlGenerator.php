<?php
declare(strict_types=1);

namespace Kaira\Domain\Url\Service;

use Kaira\Domain\Url\Model\ShortUrl;
use Kaira\Domain\Url\Model\Value\Url;

interface ShortUrlGenerator
{
    public function generate(Url $url): ShortUrl;

}
