<?php

abstract class BinProvider
{
    /**
     * @return string|null
     */
    abstract public function getBinValue(): ?string;

    /**
     * @param HttpRequestAbstract $httpRequest
     * @param string $cardNumber
     */
    public function __construct(public HttpRequestAbstract $httpRequest, public string $cardNumber)
    {
    }
}
