<?php

namespace Kaira\Infrastructure\Ui\Http\Url\SortUrls;

use Illuminate\Http\JsonResponse;
use Kaira\Application\Url\Response\ShortUrlResponse;
use Kaira\Application\Url\ShortenUrlUseCase\ShortenUrlQuery;
use Kaira\Domain\Shared\Cqrs\QueryBus;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlsController
{
    public function __construct(
        private readonly QueryBus $queryBus
    )
    {
    }


    public function __invoke(ShortUrlsRequest $sortUrlsRequest): JsonResponse
    {

        /**
         * @var ShortUrlResponse $response
         */
        $response = $this->queryBus->handle(
            new ShortenUrlQuery($sortUrlsRequest->url())
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }




}
