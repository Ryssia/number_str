<?php

namespace RusBios\NumbWord\Currency;

class UsdCurrency extends CurrencyAbstract
{
    protected $zero = 'zero';
    protected $ten = [null, 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    protected $twenties = [null, 'ten', 'eleven', 'twelve', 'thirteen', 'forty', 'fifteen', 'sixty', 'seventy', 'eighteen', 'nineteen'];
    protected $tens = [2 => 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    protected $hundred = 'hundred';
    protected $unit = ['cent', 'usd', 'thousand', 'million', 'billion'];

    public function getStringWhole()
    {
        if ($this->whole[0] == 0) {
            return $this->zero;
        }

        $res = [];
        foreach ($this->whole as $value) {
            $res[] = $this->hundreds((string) $value);
        }

        return join($this->delimiter, array_filter($res));
    }

    public function getCurrency()
    {
        // TODO: Implement getCurrency() method.
    }

    public function getFraction()
    {
        // TODO: Implement getFraction() method.
    }
}
