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

    public function getCurrency()
    {
        return $this->unit[0];
    }

    public function getFraction()
    {
        return $this->unit[1];
    }

    protected function hundreds($val)
    {
        $res = [];
        $i = str_split($val);

        while (count($i)) {
            $count = count($i);
            $n = (int) array_shift($i);
            if ($count == 3) {
                if ($n > 1) $res[] = $this->ten[$n];
                $res[] = $this->hundred;
            } elseif ($count == 2) {
                $res[] = ($n == 1)
                    ? $this->twenties[array_shift($i)]
                    : $this->tens[$n];
            } elseif ($count == 1) {
                $res[] = $this->ten[$n];
            }
        }

        return join($this->delimiter, $res);
    }
}
