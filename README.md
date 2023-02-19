# RockMoney

ProcessWire Module to provide tools for storing and using monetary values in an easy, yet powerful way.

## Usage

RockMoney will register a new API variable `$money` that you can use to work with money values:

```php
echo $money
  ->parse("1,4")
  ->minus(0.4)
  ->format(); // 1,00€
```

## Why?

Because using floats can lead to severe bugs!

```php
$x = 1.4;
$y = 0.4;
db($x - $y); // 0.9999999999999999
```

## Parsing

## Formatting

```
Number: 9988776.65
FR: 9 988 776,65
DE: 9.988.776,65
US: 9,988,776.65
```

## Links

https://entwickler.de/php/moneyphp-internationale-transaktionen-leicht-gemacht
https://www.moneyphp.org/en/stable/index.html
https://www.php.net/manual/en/class.numberformatter.php
