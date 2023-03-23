<?php
declare(strict_types=1);

namespace Kaira\Application\Url\Response;

use Kaira\Domain\Url\Model\ShortUrl;

class ShortUrlResponse
{
    const URL = 'url';
    private function __construct(
        private readonly string $url
    )
    {
    }

    public static function createFromSortUrl(ShortUrl $sortUrl): self
    {
        return new self(
            $sortUrl->getUrl()->value
        );
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        return [
            self::URL => $this->url
        ];
    }

}
