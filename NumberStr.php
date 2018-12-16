<?php
/**
 * Преобразовать float в прописной вид
 *
 * @User: Ryssia
 * @author RusBIOS
 * Date: 15.12.18
 */

class NumberStr
{
    /**
     * @var float;
     */
    private $number;

    private $nul = 'ноль';
    private $ten = array(
        ['','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'],
        ['','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'],
    );
    private $a20 = ['десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать'];
    private $tens = [2 => 'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто'];
    private $hundred = ['','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот'];
    private $unit = array(
        ['копейка', 'копейки', 'копеек'],
        ['рубль', 'рубля', 'рублей'],
        ['тысяча', 'тысячи', 'тысяч'],
        ['миллион', 'миллиона', 'миллионов'],
        ['миллиард', 'милиарда', 'миллиардов'],
    );

    /**
     * NumberStr constructor.
     * @param float $number
     */
    public function __construct(float $number)
    {
        $this->number = number_format($number, 2, ',', ' ');
    }

    /**
     * отформатировать в красивый вид
     *
     * @return string
     */
    public function getNum(): string
    {
        list($rub) = explode(',', $this->number);

        return "$rub " . $this->morph((int) substr($rub, -2), $this->unit[1][0], $this->unit[1][1], $this->unit[1][2]);
    }

    /**
     * вывод суммы прописью
     *
     * @return string
     */
    public function get(): string
    {
        return $this->getRub() . " " . $this->getKop();
    }

    /**
     * Возвращает рубли прописью
     *
     * @return string
     */
    public function getRub(): string
    {
        $out = [];
        list($rub) = explode(',',$this->number);

        if ((int) $rub > 0) {
            $rubs = array_reverse(explode(' ', $rub));

            for ($n=count($rubs)-1; $n>=0; $n--) {
                $out[] = $this->hundreds((string) $rubs[$n]);
                if ($n > 0)
                    $out[] = $this->morph((int) $rubs[$n], $this->unit[$n+1][0], $this->unit[$n+1][1], $this->unit[$n+1][2]);
            }

            $out[] = $this->morph((int) $rubs[0], $this->unit[1][0], $this->unit[1][1], $this->unit[1][2]);

        } else $out[] = $this->nul;

        return implode(' ', $out);
    }

    /**
     * Возвращаем копейки
     *
     * @return string
     */
    public function getKop(): string
    {
        list(,$kop) = explode(',',$this->number);

        $out[] = (string) $kop;

        $out[] = $this->morph($kop,$this->unit[0][0],$this->unit[0][1],$this->unit[0][2]);

        return implode(' ', $out);
    }

    /**
     * цыфры в слова
     *
     * @param string $val
     * @return string
     */
    private function hundreds(string $val): string
    {
        $res = [];
        $i = str_split($val);

        switch (count($i)) {
            case 3:
                $res[] = $this->hundred[(int) $i[0]];
                if ((int) $i[1] > 1) {
                    $res[] = $this->tens[(int) $i[1]];
                    $res[] = $this->ten[0][(int) $i[2]];
                } else $res[] = $this->a20[(int) $i[2]];
                break;

            case 2:
                if ((int) $i[0] > 1) {
                    $res[] = $this->tens[(int) $i[0]];
                    $res[] = $this->ten[0][(int) $i[1]];
                } else $res[] = $this->a20[(int) $i[1]];
                break;

            case 1:
                $res[] = $this->ten[0][(int) $i[0]];
                break;
        }

        return implode(' ', $res);
    }

    /**
     * Склоняем словоформу
     *
     * @param int $n
     * @param string $f1
     * @param string $f2
     * @param string $f5
     * @return string
     */
    private function morph(int $n, string $f1, string $f2, string $f5): string
    {
        $n = abs($n) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n === 1) return $f1;
        return $f5;
    }
}
