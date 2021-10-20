<?php

namespace App\Service;

class GenerateCodeService implements GenerateCodeServiceInterface
{
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


    /**
     * @param int $numberCode
     * @param int $length
     * @return array
     * @throws \Exception
     */
    public function generate(int $numberCode = 2, int $length = 10): array
    {

        $charactersLength = strlen(self::CHARACTERS);

        $a = 0;
        $randomCodes = [];
        do {
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= self::CHARACTERS[random_int(0, $charactersLength - 1)];
                if (strlen($randomString) === $length) {
                    $randomCodes[] = $randomString;
                }
            }

            $a++;
        } while ($a < $numberCode);


        return $randomCodes;
    }
}
