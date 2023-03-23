<?php
declare(strict_types=1);

namespace Tests\Feature\Trait;



trait TestUtilsTrait
{

    private function validToken(): string
    {
        return 'Bearer ()';
    }
    private function invalidToken(): string
    {
        return 'Bearer (]';
    }

    private function getExceptionSortClassName(string $exception): string
    {
        $parts = explode('\\', $exception);
        return end($parts);
    }

}
