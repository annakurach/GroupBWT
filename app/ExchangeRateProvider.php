<?php

use Config\Data;

class ExchangeRateProvider extends RatesProvider
{
    /**
     * @param string $currency
     * @return float|int|null
     */
    public function getRatesValue(string $currency): float|int|null
    {
        $this->httpRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->httpRequest->setOption(CURLOPT_URL, $this->httpRequest->url);
        if (!empty(Data::RATES_API_USER) && !empty(Data::RATES_API_PASSWORD)) {
            $this->httpRequest->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $this->httpRequest->setOption(
                CURLOPT_USERPWD,
                Data::RATES_API_USER . ":" . Data::RATES_API_PASSWORD
            );
        }
        $result = $this->httpRequest->execute();
        $this->httpRequest->close();
        return json_decode($result)?->rates?->$currency;
    }
}
