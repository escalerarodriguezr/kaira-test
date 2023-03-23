<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kaira\Infrastructure\Ui\Security\AccessTokenValidator;
use Symfony\Component\HttpFoundation\Response;

class AuthTokenIsValid
{

    public function __construct(
        private readonly AccessTokenValidator $accessTokenValidator
    )
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization', null);

        if($token === null){
            throw new AuthenticationException('Missing Access Token');
        }

        if (!Str::startsWith($token, 'Bearer')) {
            throw new AuthenticationException('Invalid Access Token');
        }

        $token = Str::substr($token, 7);

        if( $this->accessTokenValidator->__invoke($token) === false ){
            throw new AuthenticationException('Invalid Access Token');
        }

        return $next($request);
    }
}
