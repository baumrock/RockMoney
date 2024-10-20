# RockMoney

RockMoney provides tools for storing and using monetary values in an easy, yet powerful way. This module is based on https://github.com/moneyphp/money and a required module for [RockCommerce](https://www.baumrock.com/RockCommerce), which uses it to handle all prices.

## Usage

```php
echo rockmoney()
  ->parse("1,4")
  ->minus(0.4)
  ->format(); // 1,00€
```

See detailed usage instructions in the dedicated section.

## Why?

The simple answer is, because **0.1 + 0.2 is not 0.3** in computer world:

<img src=https://i.imgur.com/xsFjHPJ.png class=blur height=200>

This behaviour is caused by computers calculating numbers in binary, not in decimal as we are used to. This leads to some numbers like 0.2 being periodic in binary, which will cause rounding issues all over.

Things might look correct 99% of the time, but suddenly you might get "wrong" results like this and you are knee deep in trouble:

<img src=https://i.imgur.com/Nyh4JzW.png class=blur height=600>

## Links

https://entwickler.de/php/moneyphp-internationale-transaktionen-leicht-gemacht
https://www.moneyphp.org/en/stable/index.html
https://www.php.net/manual/en/class.numberformatter.php
