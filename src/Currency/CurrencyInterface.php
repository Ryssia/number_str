<?php

namespace RusBios\NumbWord\Currency;

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
}
