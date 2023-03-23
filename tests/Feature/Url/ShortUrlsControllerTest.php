<?php
declare(strict_types=1);

namespace Tests\Feature\Url;

use App\Exceptions\Handler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Testing\Fluent\AssertableJson;
use Kaira\Application\Url\Response\ShortUrlResponse;
use Kaira\Infrastructure\Ui\Http\Url\SortUrls\ShortUrlsRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\Trait\TestUtilsTrait;
use Tests\TestCase;

class ShortUrlsControllerTest extends TestCase
{
    use TestUtilsTrait;

    const END_POINT = '/api/v1/short-urls';

    public function testSuccessResponse(): void
    {
        $payload =[
          ShortUrlsRequest::URL => 'https://laravel.com'
        ];

        $response = $this->withHeader('Authorization', $this->validToken())
            ->json(
                Request::METHOD_POST,
              self::END_POINT,
                $payload
            );

        $response->assertStatus(Response::HTTP_OK);

        $responseArray = json_decode($response->content(),true);

        self::assertArrayHasKey(ShortUrlResponse::URL, $responseArray);
        self::assertIsString($responseArray[ShortUrlResponse::URL]);

    }

    public function testResponseAuthenticationException(): void
    {

        $payload =[
            ShortUrlsRequest::URL => 'https://laravel.com'
        ];

        $response = $this->withHeader('Authorization', $this->invalidToken())
            ->json(
                Request::METHOD_POST,
                self::END_POINT,
                $payload
            );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertJsonPath(
            Handler::EXCEPTION,
            $this->getExceptionSortClassName(AuthenticationException::class)
        );


    }

    public function testResponseValidationException(): void
    {
        $payload =[
            ShortUrlsRequest::URL => ''
        ];

        $response = $this->withHeader('Authorization', $this->validToken())
            ->json(
                Request::METHOD_POST,
                self::END_POINT,
                $payload
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('exception')
            ->has('errors', 1)
            ->has('errors.url')
        );
    }
}
