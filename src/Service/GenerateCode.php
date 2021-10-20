<?php

namespace App\Service;

class GenerateCode
{

    /**
     * @throws \Exception
     */
    public function generate($numberCode, $length):array
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $a = 0;
        $randomCodes=[];
        do {
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
                if (strlen($randomString) === $length) {
                    $randomCodes[] = $randomString;
                }
            }

            $a++;
        } while ($a<$numberCode);


        return $randomCodes;
    }
}
