<?php
declare(strict_types=1);

namespace Kaira\Infrastructure\Ui\Security;

class AccessTokenValidator
{
    public function __construct(
        private readonly array $validCharacters,
        private readonly array $validOpenedCharacters,
        private readonly array $validClosedCharacters
    )
    {

    }

    public function __invoke(string $token): bool
    {
        if(empty($token)){
            return true;
        }

        $stack = [];
        $tokenCharacters = str_split($token);

        if((count($tokenCharacters))%2 !== 0){
            return false;
        }

        foreach ($tokenCharacters as $character){

            if(!in_array($character,$this->validCharacters)){
                return false;
            }

            if(in_array($character,$this->validOpenedCharacters)){
                $stack[] = $character;
            }

            if(in_array($character,$this->validClosedCharacters)){

                if(count($stack) === 0){
                    return false;
                }

                $closedCharacterKey = array_search(
                    $character,
                    $this->validClosedCharacters
                );

                $lastOpenedCharacterInStack = array_pop($stack);

                $lastOpenedCharacterInStackKey = array_search(
                    $lastOpenedCharacterInStack,
                    $this->validOpenedCharacters
                );

                if($closedCharacterKey != $lastOpenedCharacterInStackKey){
                    return false;
                }
            }

        }

        return true;
    }

}
