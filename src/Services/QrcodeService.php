<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
class QrcodeService
{
    public function generateQrCode(string $adressCrypto): string
    {
        $result = Builder::create()
            ->data($adressCrypto)
            ->build();

        $dataUri = $result->getDataUri();

        return $dataUri;
    }
}
