<?php

namespace RusBios\NumbWord\Currency;

class RubCurrency extends CurrencyAbstract
{
    protected $zero = 'ноль';
    protected $ten = [
        [null, 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        [null, 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
    ];
    protected $twenties = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
    protected $tens = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
    protected $hundred = [null, 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
    protected $unit = [
        ['копейка', 'копейки', 'копеек'],
        ['рубль', 'рубля', 'рублей'],
        ['тысяча', 'тысячи', 'тысяч'],
        ['миллион', 'миллиона', 'миллионов'],
        ['миллиард', 'милиарда', 'миллиардов'],
    ];

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
        return $this->morph($this->whole[0], $this->unit[1][0], $this->unit[1][1], $this->unit[1][2]);
    }

    public function getFraction()
    {
        return $this->morph($this->fraction, $this->unit[0][0], $this->unit[0][1], $this->unit[0][2]);
    }

    /**
     * @param string $val
     * @return string
     */
    protected function hundreds($val)
    {
        $res = [];
        $i = str_split($val);

        switch (count($i)) {
            case 3:
                $res[] = $this->hundred[(int)$i[0]];
                if ((int) $i[1] > 1) {
                    $res[] = $this->tens[(int)$i[1]];
                    $res[] = $this->ten[0][(int)$i[2]];
                } else {
                    $res[] = $this->twenties[(int)$i[2]];
                }
                break;

            case 2:
                if ((int) $i[0] > 1) {
                    $res[] = $this->tens[(int)$i[0]];
                    $res[] = $this->ten[0][(int)$i[1]];
                } else {
                    $res[] = $this->twenties[(int)$i[1]];
                }
                break;

            case 1:
                $res[] = $this->ten[0][(int)$i[0]];
                break;
        }

        return join('', $res);
    }

    /**
     * @param int $n
     * @param string $f1
     * @param string $f2
     * @param string $f5
     * @return string
     */
    protected function morph(int $n, $f1, $f2, $f5)
    {
        $n = abs($n) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n === 1) return $f1;
        return $f5;
    }
}
