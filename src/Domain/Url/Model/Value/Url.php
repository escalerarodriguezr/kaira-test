<?php
declare(strict_types=1);

namespace Kaira\Domain\Url\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Url
{
    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::url($value,);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid url', $value));
        }
    }

}
