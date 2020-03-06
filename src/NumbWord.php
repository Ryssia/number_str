<?php

namespace RusBios\NumbWord;

use Exception;
use RusBios\NumbWord\Currency;

class NumbWord
{
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_USD = 'USD';
    const CURRENCY_JPY = 'JPY';

    /**
     * @param float $number
     * @param string $currency
     * @return Currency\CurrencyInterface
     * @throws Exception
     */
    public static function getCurrency(float $number, $currency = self::CURRENCY_USD)
    {
        switch ($currency) {
            case static::CURRENCY_RUB:
                return new Currency\RubCurrency($number);
            case static::CURRENCY_USD:
                return new Currency\UsdCurrency($number);
        }
        throw new Exception(sprintf('Not "%s" currency the library', $currency));
    }
}
