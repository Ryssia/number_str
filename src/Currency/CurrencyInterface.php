<?php

namespace RusBios\NumbWord\Currency;

use Exception;

interface CurrencyInterface
{
    /**
     * CurrencyInterface constructor.
     * @param float $number
     */
    public function __construct(float $number);

    /**
     * @return string
     */
    public function getNumber();

    /**
     * @return string
     */
    public function getStringPrice();

    /**
     * @return string
     */
    public function getStringWhole();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return int
     */
    public function getNumberFraction();

    /**
     * @return string
     */
    public function getFraction();

    /**
     * @param string $currency
     * @param float $rate
     * @return CurrencyInterface
     * @throws Exception
     */
    public function convert($currency, float $rate = 1);

    /**
     * @param string $delimiter
     * @return CurrencyInterface
     */
    public function setDelimiter($delimiter);

    /**
     * @return float
     */
    public function getFloat();
}
