<?php

namespace Tests\Unit\src\Infrastructure\Ui\Security;

use Kaira\Infrastructure\Ui\Security\AccessTokenValidator;
use PHPUnit\Framework\TestCase;

class AccessTokenValidatorTest extends TestCase
{
    private AccessTokenValidator $accessTokenValidator;
    protected function setUp(): void
    {
        $validCharacters = ['{','}','(',')','[',']'];
        $validOpenedCharacters = ['{','(','['];
        $validClosedCharacters = ['}',')',']'];

        $this->accessTokenValidator = new AccessTokenValidator(
            $validCharacters,
            $validOpenedCharacters,
            $validClosedCharacters
        );

        parent::setUp();
    }

    public function testTokenEmptyStringInRequest(): void
    {
        $token = '';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertTrue($isValid);
    }

    public function testTokenOddCharactersInRequest(): void
    {
        $token = '(()';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertFalse($isValid);
    }

    public function testTokenCasesValidationInRequest(): void
    {
        $token = '{}';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertTrue($isValid);

        $token = '{}[]()';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertTrue($isValid);

        $token = '{)';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertFalse($isValid);

        $token = '[{]}';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertFalse($isValid);

        $token = '{([])}';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertTrue($isValid);

        $token = '(((((((()';
        $isValid = $this->accessTokenValidator->__invoke($token);
        self::assertFalse($isValid);
    }

}
