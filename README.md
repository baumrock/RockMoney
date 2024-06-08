# RockMoney

ProcessWire Module to provide tools for storing and using monetary values in an easy, yet powerful way. This module is based on https://github.com/moneyphp/money

## Usage

```php
echo rockmoney()
  ->parse("1,4")
  ->minus(0.4)
  ->format(); // 1,00€
```

## Why?

Because using floats can lead to severe problems! Compare the previous examle with this one:

```php
$x = 1.4;
$y = 0.4;
db($x - $y); // 0.9999999999999999 (not 1!)
```

## Parsing

## Formatting

All money objects will be automatically formatted according to the module settings.

#### String Casting

RockMoney objects will automatically format themselves when requested for output:

```php
$net = rockmoney()->parse(100);
bd($net); // RockMoney\Money object
echo $net; // 100,00€
```

## Calculations

```php
rockmoney()
  ->parse("14,40")
  ->plus(3)
  ->minus(0.4)
  ->format(); // 17,00€
```

### Immutability

Note that every calculation will return a new money object instead of modifying the original object. This is important for situations like this one:

```php
$net = rockmoney()->parse("1.499");
$vat = $net->times(0.2); // $net is still 1499
$gross = $net->plus($vat); // $net is still 1499
echo "net: $net"; // 1.499,00€
echo "vat: $vat"; // 299,80€
echo "gross: $gross"; // 1.798,80€
```

## Comparisons

```php
$net = rockmoney()->parse(100);
$vat = $net->times(0.2);
$gross = $net->times(1.2);
$gross2 = $net->plus($vat);
bd($gross->isEqual($gross2)); // true
```

## Fieldtype

```php
// find invoices with net value smaller than 100€
$pages->find("template=invoice, net<100");
```

## Links

https://entwickler.de/php/moneyphp-internationale-transaktionen-leicht-gemacht
https://www.moneyphp.org/en/stable/index.html
https://www.php.net/manual/en/class.numberformatter.php
