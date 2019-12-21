<?php

namespace RusBios\NumbWord\Currency;

class RubCurrency implements CurrencyInterface
{
    /** @var int[] */
    protected $whole;

    /** @var int $fraction */
    protected $fraction;

    protected $delimiter = ' ';
    protected $zero = 'ноль';
    protected $ten = [
        ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
    ];
    protected $twenties = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
    protected $tens = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
    protected $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
    protected $unit = [
        ['копейка', 'копейки', 'копеек'],
        ['рубль', 'рубля', 'рублей'],
        ['тысяча', 'тысячи', 'тысяч'],
        ['миллион', 'миллиона', 'миллионов'],
        ['миллиард', 'милиарда', 'миллиардов'],
    ];

    /**
     * NumbWord constructor.
     * @param float $number
     */
    public function __construct(float $number)
    {
        $tmp = explode(',', number_format($number, 2, ',', ','));
        $this->fraction = (int) array_pop($tmp);
        $this->whole = array_reverse($tmp);
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return sprintf('%s,%s', join($this->delimiter, array_reverse($this->whole)), $this->fraction);
    }

    /**
     * @return string
     */
    public function getStringPrice()
    {
        return join($this->delimiter, [
            $this->getStringWhole(),
            $this->getCurrency(),
            $this->getNumberFraction(),
            $this->getFraction(),
        ]);
    }

    /**
     * @return string
     */
    public function getStringWhole()
    {
        if ($this->whole[0] == 0) {
            return $this->zero;
        }

        $res = [];
        foreach ($this->whole as $value) {
            $res[] = $this->hundreds((string) $value);
        }

        return implode(' ', $res);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->morph($this->whole[0], $this->unit[1][0], $this->unit[1][1], $this->unit[1][2]);
    }

    /**
     * @return int
     */
    public function getNumberFraction()
    {
        return $this->fraction;
    }

    /**
     * @return string
     */
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
