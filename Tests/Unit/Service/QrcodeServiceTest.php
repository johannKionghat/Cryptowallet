<?php

use PHPUnit\Framework\TestCase;
use App\Services\QrcodeService;

class QrcodeServiceTest extends TestCase
{
    /** @var QrcodeService */
    private $qrcodeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrcodeService = new QrcodeService();
    }

    public function testGenerateQrCode(): void
    {
        $cryptoAddress = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'; 
        $dataUri = $this->qrcodeService->generateQrCode($cryptoAddress);
        $this->assertNotEmpty($dataUri);
        $this->assertStringStartsWith('data:image/png;base64,', $dataUri);

    }
}
