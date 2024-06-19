<?php

namespace App\Services;

class GenerateAdressCrypto 
{
    public function generateAdressCrypto(string $adressCrypto): string
    {
        $adressCrypto = base64_encode($adressCrypto);
        return $adressCrypto;
    }
}