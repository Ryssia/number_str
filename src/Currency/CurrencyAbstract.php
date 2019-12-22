<?php

namespace RusBios\NumbWord\Currency;

use RusBios\NumbWord\NumbWord;

abstract class CurrencyAbstract implements CurrencyInterface
{
    /** @var int[] */
    protected $whole;

    /** @var int $fraction */
    protected $fraction;

    /** @var string $delimiter */
    protected $delimiter = ' ';

    /** @var string $zero */
    protected $zero;

    /** @var array $ten */
    protected $ten;

    /** @var array $twenties */
    protected $twenties;

    /** @var array $tens */
    protected $tens;

    /** @var array $hundred */
    protected $hundred;

    /** @var array $unit */
    protected $unit;

    public function __construct(float $number)
    {
        $tmp = explode(',', number_format($number, 2, ',', ','));
        $this->fraction = (int) array_pop($tmp);
        $this->whole = $tmp;
    }

    public function getNumber()
    {
        return join($this->delimiter, [
            join($this->delimiter, $this->whole),
            sprintf('%s,', $this->getCurrency()),
            $this->fraction,
            $this->getFraction(),
        ]);
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

    public function getStringWhole()
    {
        if ($this->whole[0] == 0 && count($this->whole) == 1) {
            return $this->zero;
        }

        $res = [];
        foreach ($this->whole as $key => $value) {
            $unitKey = count($this->whole) - $key;
            $res[] = $this->hundreds((string) $value);
            if ($unitKey > 1) {
                $res[] = $this->morph($value, $this->unit[$unitKey][0], $this->unit[$unitKey][1], $this->unit[$unitKey][2]);
            }
        }

        return join($this->delimiter, array_filter($res));
    }

    public function getCurrency()
    {
        return $this->morph(end($this->whole), $this->unit[1][0], $this->unit[1][1], $this->unit[1][2]);
    }

    public function getFraction()
    {
        return $this->morph($this->fraction, $this->unit[0][0], $this->unit[0][1], $this->unit[0][2]);
    }

    public function convert($currency, float $rate = 1)
    {
        return NumbWord::getCurrency(($this->getFloat() * $rate), $currency);
    }

    public function getFloat()
    {
        return (float) sprintf('%s.%s', join('', $this->whole), $this->fraction);
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
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

        return join($this->delimiter, $res);
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
