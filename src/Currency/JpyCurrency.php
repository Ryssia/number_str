<?php

namespace RusBios\NumbWord\Currency;

use Exception;

class JpyCurrency extends CurrencyAbstract
{
    protected $zero = 'ぜろ';
    protected $ten = [null, 'いち', 'に', 'さん', 'よん', 'ご', 'ろく', 'なな', 'はち', 'きゅう'];
    protected $tens = 'じゅう';
    protected $hundred = 'ひゃく';
    protected $thousand = 'せん';
    protected $million = 'まん';
    protected $billion = 'おく';
    protected $unit = '¥';
    protected $cent = 'セント';
    protected $delimiter = '';

    public function getStringWhole()
    {
        if ($this->whole[0] == 0 && count($this->whole) == 1) {
            return $this->zero;
        }

        $res = [];
        foreach ($this->whole as $key => $value) {
            $res[] = $this->hundreds((string) $value);

            if (count($this->whole) === 4 && $key === 0) $result[] = $this->billion;
            if (count($this->whole) === 4 && $key === 1) $result[] = $this->million;
            if (count($this->whole) === 4 && $key === 2) $result[] = $this->thousand;

            if (count($this->whole) === 3 && $key === 0) $result[] = $this->million;
            if (count($this->whole) === 3 && $key === 1) $result[] = $this->thousand;

            if (count($this->whole) === 2 && $key === 0) $result[] = $this->thousand;
        }

        return join($this->delimiter, array_filter($res));
    }

    protected function hundreds($val)
    {
        $nums = explode('', $val);

        $result = [];
        foreach ($nums as $key => $n) {
            $result[] = $this->ten[$n];

            if (count($nums) === 3 && $key === 0) $result[] = $this->hundred;
            if (count($nums) === 3 && $key === 1) $result[] = $this->tens;

            if (count($nums) === 2 && $key === 0) $result[] = $this->tens;
        }

        return join($this->delimiter, $result);
    }

    public function getCurrency()
    {
        return $this->unit;
    }

    public function getFraction()
    {
        return $this->cent;
    }
}
