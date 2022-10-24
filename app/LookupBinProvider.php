<?php

use Config\Data;

class LookupBinProvider extends BinProvider
{
    /**
     * @return string|null
     */
    public function getBinValue(): ?string
    {
        $this->httpRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->httpRequest->setOption(CURLOPT_URL, $this->httpRequest->url . $this->cardNumber);
        if (!empty(Data::BIN_API_USER) && !empty(Data::BIN_API_PASSWORD)) {
            $this->httpRequest->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $this->httpRequest->setOption(
                CURLOPT_USERPWD,
                Data::BIN_API_USER . ":" . Data::BIN_API_PASSWORD
            );
        }
        $result = $this->httpRequest->execute();
        $this->httpRequest->close();
        return json_decode($result)?->country?->alpha2;
    }
}
