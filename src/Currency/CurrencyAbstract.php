<?php

namespace RusBios\NumbWord\Currency;

use RusBios\NumbWord\NumbWord;

abstract class CurrencyAbstract implements CurrencyInterface
{
    /** @var int[] */
    protected $whole;

    /** @var int $fraction */
    protected $fraction;

    protected $delimiter = ' ';

    public function __construct(float $number)
    {
        $tmp = explode(',', number_format($number, 2, ',', ','));
        $this->fraction = (int) array_pop($tmp);
        $this->whole = array_reverse($tmp);
    }

    public function getNumber()
    {
        return sprintf('%s,%s', join($this->delimiter, array_reverse($this->whole)), $this->fraction);
    }

    public function getStringPrice()
    {
        return join($this->delimiter, [
            $this->getStringWhole(),
            $this->getCurrency(),
            $this->getNumberFraction(),
            $this->getFraction(),
        ]);
    }

    public function getNumberFraction()
    {
        return $this->fraction;
    }

    public function convert($currency, float $rate = 1)
    {
        return NumbWord::getCurrency(((float) $this->getNumber() * $rate), $currency);
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}
