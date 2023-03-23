<?php
declare(strict_types=1);

namespace Kaira\Application\Url\ShortenUrlUseCase;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Kaira\Domain\Shared\Cqrs\QueryValidatorException;


class ShortenUrlQueryValidator
{

    public function __invoke(ShortenUrlQuery $query): void
    {
        try {
            Assertion::url($query->url,);
        } catch(AssertionFailedException $exception) {
            throw QueryValidatorException::fromQuery($query,sprintf('url: %s', $query->url));
        }
    }

}
