# Number Words
<p>Tool for textual presentation of prices</p>

## Install
<code>$ composer require rusbios/numb-word</code>

## Examples of using
<code>$numbWord = NumbWord::getCurrency(125.32, NumbWord::CURRENCY_RUB);</code><br>
<code>$numbWord->getStringPrice(); // сто дватсять пять рублей 32 копейки</code>