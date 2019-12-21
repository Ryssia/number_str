<?php

namespace RusBios\NumbWord;

use Exception;
use RusBios\NumbWord\Currency\RubCurrency;

class NumbWord
{
    const RUB = 'RUB';

    /**
     * @param float $number
     * @param string $currency
     * @return RubCurrency
     * @throws Exception
     */
    public static function getCurrency(float $number, $currency = 'RUB')
    {
        switch ($currency) {
            case static::RUB:
                return new RubCurrency($number);
        }
        throw new Exception(sprintf('Not "%s" currency the library', $currency));
    }
}
