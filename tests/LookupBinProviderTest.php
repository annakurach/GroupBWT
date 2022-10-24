<?php

namespace tests;

use BinProvider;
use HttpRequestAbstract;
use LookupBinProvider;
use PHPUnit\Framework\TestCase;

class LookupBinProviderTest extends TestCase
{
    public HttpRequestAbstract $httpRequest;
    public BinProvider $binProvider;

    protected function setUp(): void
    {
        $this->httpRequest = $this->createMock(HttpRequestAbstract::class);
        $this->httpRequest->url = 'https://lookup.binlist.net/';
        $cardNumber = '41567';
        $this->binProvider = new LookupBinProvider($this->httpRequest, $cardNumber);
    }

    /**
     * @return void
     */
    public function testGetDataSuccess(): void
    {
        $binData = '{"number":{"length":16,"luhn":true},"scheme":"visa","type":"debit","brand":"Visa/Dankort","prepaid":false,"country":{"numeric":"208","alpha2":"DK","name":"Denmark","emoji":"🇩🇰","currency":"DKK","latitude":56,"longitude":10},"bank":{"name":"Jyske Bank","url":"www.jyskebank.dk","phone":"+4589893300","city":"Hjørring"}}';
        $this->httpRequest
            ->expects($this->atLeast(2))
            ->method('setOption');
        $this->httpRequest
            ->expects($this->once())
            ->method('execute')
            ->willReturn($binData);
        $this->httpRequest
            ->expects($this->once())
            ->method('close');
        $result = $this->binProvider->getBinValue();
        $this->assertIsString($result);
    }

    /**
     * @return void
     */
    public function testGetDataFails(): void
    {
        $this->httpRequest
            ->expects($this->atLeast(2))
            ->method('setOption');
        $this->httpRequest
            ->expects($this->once())
            ->method('execute')
            ->willReturn(false);
        $this->httpRequest
            ->expects($this->once())
            ->method('close');
        $result = $this->binProvider->getBinValue();
        $this->assertNull($result);
    }
}
