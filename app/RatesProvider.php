<?php

abstract class RatesProvider
{
    /**
     * @param string $currency
     * @return float|int|null
     */
    abstract public function getRatesValue(string $currency): float|int|null;

    /**
     * @param HttpRequestAbstract $httpRequest
     */
    public function __construct(public HttpRequestAbstract $httpRequest)
    {
    }
}
