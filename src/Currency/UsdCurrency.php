<?php

namespace RusBios\NumbWord\Currency;

class UsdCurrency extends CurrencyAbstract
{
    protected $zero = 'zero';
    protected $ten = [null, 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    protected $twenties = ['ten', 'eleven', 'twelve', 'thirteen', 'forty', 'fifteen', 'sixty', 'seventy', 'eighteen', 'nineteen'];
    protected $tens = [2 => 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    protected $hundred = [null, 'one hundred', 'two hundred', 'three hundred', 'four hundred', 'five hundred', 'six hundred', 'seven hundred', 'eight hundred', 'nine hundred'];
    protected $unit = [
        ['cent', 'cent', 'cents'],
        ['dollar', 'dollar', 'dollars'],
        ['thousand', 'thousands', 'thousand'],
        ['million', 'million', 'million'],
        ['billion', 'billion', 'billion'],
    ];
}
