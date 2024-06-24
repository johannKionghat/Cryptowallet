<?php

use PHPUnit\Framework\TestCase;
use App\Services\GenerateAdressCrypto;

class GenerateAdressCryptoTest extends TestCase
{
    /** @var GenerateAdressCrypto */
    private $generateAdressCrypto;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generateAdressCrypto = new GenerateAdressCrypto();
    }

    public function testGenerateAdressCrypto(): void
    {
        $cryptoAddress = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'; 
        $encodedAddress = $this->generateAdressCrypto->generateAdressCrypto($cryptoAddress);
        $this->assertNotEmpty($encodedAddress);
        $this->assertEquals(base64_encode($cryptoAddress), $encodedAddress);
    }
}
