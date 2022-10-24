<?php

namespace Config;

final class Data
{
    /**
     * Variable constants
     */
    public const BIN_URL = 'https://lookup.binlist.net/';
    public const BIN_API_USER = '';
    public const BIN_API_PASSWORD = '';
    public const RATES_API_USER = '';
    public const RATES_API_PASSWORD = '';
    public const RATES_URL = 'https://api.exchangerate.host/latest';
    public const EUROPEAN_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];
    public const EUROPEAN_INDEX = 0.01;
    public const NON_EUROPEAN_INDEX = 0.02;
}
