<?php

namespace RusBios\NumbWordTest;

use Exception;
use PHPUnit\Framework\TestCase;
use RusBios\NumbWord\Currency\CurrencyInterface;
use RusBios\NumbWord\NumbWord;

class NumbWordTest extends TestCase
{
    /**
     * @return CurrencyInterface|void
     */
    public function testGetCurrency()
    {
        try {
            $currency = NumbWord::getCurrency(9863568123.32, NumbWord::CURRENCY_RUB);
            $this->assertTrue($currency instanceof CurrencyInterface);
            return $currency;
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * @depends testGetCurrency
     * @param CurrencyInterface $currency
     */
    public function testGetException(CurrencyInterface $currency)
    {
        try {
            $currency->convert('111');
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @depends testGetCurrency
     * @param CurrencyInterface $currency
     */
    public function testGetStringPrice(CurrencyInterface $currency)
    {
        $this->assertTrue($currency->getStringPrice() == 'девять миллиардов восемьсот шестьдесят три миллиона пятьсот шестьдесят восемь тысяч сто двадцать три рубля 32 копейки');
    }

    /**
     * @depends testGetCurrency
     * @param CurrencyInterface $currency
     */
    public function testGetNumber(CurrencyInterface $currency)
    {
        $this->assertTrue($currency->getNumber() == '9 863 568 123 рубля, 32 копейки');
    }

    /**
     * @depends testGetCurrency
     * @param CurrencyInterface $currency
     * @throws Exception
     */
    public function testGetConvert(CurrencyInterface $currency)
    {
        $this->assertTrue($currency->convert(NumbWord::CURRENCY_USD, 1) instanceof CurrencyInterface);
    }

    /**
     * @depends testGetCurrency
     * @param CurrencyInterface $currency
     */
    public function testGetFloat(CurrencyInterface $currency)
    {
        $this->assertTrue($currency->getFloat() === 9863568123.32);
    }
}
