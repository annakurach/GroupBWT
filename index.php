<?php

use Config\Data;

require __DIR__ . '/vendor/autoload.php';

$input = new Input($argv[1]);
$transactions = $input->getInputData();
foreach ($transactions as $transaction) {
    $amount = $transaction->amount;
    $currency = $transaction->currency;
    $cardNumber = $transaction->bin;
    $binHttpRequest = new CurlRequest(Data::BIN_URL);
    $ratesHttpRequest = new CurlRequest(Data::RATES_URL);
    $binProvider = new LookupBinProvider($binHttpRequest, $cardNumber);
    $ratesProvider = new ExchangeRateProvider($ratesHttpRequest);
    $commissionCalculator = new CommissionCalculator($binProvider, $ratesProvider);
    try {
        echo $commissionCalculator->calculate($amount, $currency);
        echo "\n";
    } catch (Exception $e) {
        echo 'Something went wrong';
    }
}
