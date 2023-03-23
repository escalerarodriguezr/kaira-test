<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Kaira\Domain\Shared\Cqrs\CommandGuardException;
use Kaira\Domain\Shared\Cqrs\CommandValidatorException;
use Kaira\Domain\Shared\Cqrs\QueryGuardException;
use Kaira\Domain\Shared\Cqrs\QueryValidatorException;
use Kaira\Infrastructure\Service\TinyUrlGenerator\TinyUrlGeneratorException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    const ERRORS_KEY = 'errors';
    const CLASS_KEY = 'class';
    const CODE_KEY = 'code';
    const MESSAGE_KEY = 'message';
    const EXCEPTION = 'exception';

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [

    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });

        $this->renderable(function (Throwable $e, $request) {

            if($e instanceof AuthenticationException){
                return response()->json([
                    self::EXCEPTION => $this->getSortClassName(get_class($e)),
                    self::MESSAGE_KEY => $e->getMessage(),
                    self::CODE_KEY => Response::HTTP_UNAUTHORIZED
                ], Response::HTTP_UNAUTHORIZED);
            }

            if( $e instanceof NotFoundHttpException){
                return response()->json([
                    self::EXCEPTION => $this->getSortClassName(get_class($e)),
                    self::MESSAGE_KEY => $e->getMessage(),
                    self::CODE_KEY => $e->getStatusCode()
                ], $e->getStatusCode());
            }

            if( $e instanceof ValidationException){
                return response()->json([
                    self::EXCEPTION => $this->getSortClassName(get_class($e)),
                    self::ERRORS_KEY => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }


            if (\in_array(\get_class($e), $this->getInfrastructureServiceException(), true)) {
                return response()->json([
                    self::EXCEPTION => $this->getSortClassName(get_class($e)),
                    self::MESSAGE_KEY => $e->getMessage(),
                    self::CODE_KEY => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if (\in_array(\get_class($e), $this->getConflictExceptions(), true)) {
                return response()->json([
                    self::EXCEPTION => $this->getSortClassName(get_class($e)),
                    self::MESSAGE_KEY => $e->getMessage(),
                    self::CODE_KEY => Response::HTTP_CONFLICT
                ], Response::HTTP_CONFLICT);
            }


            if(env('APP_ENV') === 'local'){
                return response()->json([
                    self::EXCEPTION => get_class($e),
                    self::MESSAGE_KEY => $e->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }else{
                return response()->json([
                    self::MESSAGE_KEY => 'Internal Server Error',
                    self::CODE_KEY => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        });
    }

    private function getSortClassName(string $className): string
    {
        $parts = explode('\\', $className);
        return end($parts);
    }


    private function getInfrastructureServiceException(): array
    {
        return [
            TinyUrlGeneratorException::class,
        ];
    }

    private function getConflictExceptions(): array
    {
        return [
            CommandGuardException::class,
            CommandValidatorException::class,
            QueryGuardException::class,
            QueryValidatorException::class,
        ];
    }

}
