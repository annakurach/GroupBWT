<?php

use Config\Data;

class CommissionCalculator
{
    /**
     * @param BinProvider $binProvider
     * @param RatesProvider $ratesProvider
     */
    public function __construct(
        public BinProvider $binProvider,
        public RatesProvider $ratesProvider,
    ) {
    }

    /**
     * @param $amount
     * @param $currency
     * @return float|int
     * @throws Exception
     */
    public function calculate($amount, $currency): float|int
    {
        $countryCode = $this->binProvider->getBinValue();
        if (!$countryCode) {
            throw new Exception('Country code is not valid.');
        }
        $ratesValue = $this->ratesProvider->getRatesValue($currency);
        $index = $this->getIndex($countryCode);
        if (!$ratesValue || $ratesValue < 0) {
            throw new Exception('Rate is not valid.');
        }
        if ($currency == 'EUR' || $ratesValue == 0) {
            $fixedAmount = $amount;
        } else {
            $fixedAmount = $amount / $ratesValue;
        }

        return round($fixedAmount * $index, 2);
    }

    /**
     * @param string $countryCode
     * @return float
     */
    private function getIndex(string $countryCode): float
    {
        return $this->isEurope($countryCode) ? Data::EUROPEAN_INDEX : Data::NON_EUROPEAN_INDEX;
    }

    /**
     * @param string $country
     * @return bool
     */
    private function isEurope(string $country): bool
    {
        return in_array($country, Data::EUROPEAN_COUNTRIES);
    }
}
