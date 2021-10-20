<?php

namespace App\Service;

interface GenerateCodeServiceInterface
{
    /**
     * @param int $numberCode
     * @param int $length
     * @return array
     */
    public function generate(int $numberCode, int $length): array;
}
