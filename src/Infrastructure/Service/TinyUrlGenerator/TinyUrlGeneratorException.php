<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Service\TinyUrlGenerator;

use Kaira\Domain\Url\Model\Value\Url;

class TinyUrlGeneratorException extends \RuntimeException
{
    public static function withUrl(Url $ur):self
    {
        return new self(sprintf('TinyUrlGenerator service not available'));
    }

}
