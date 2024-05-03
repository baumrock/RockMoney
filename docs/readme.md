# RockMoney

RockMoney is a module that provides a simple and efficient way to handle money and currency in your applications. It supports parsing from strings, floats and provides methods for arithmetic operations.

Please note that using floats instead of money objects can lead to wrong results due to the way PHP handles floating point arithmetic.

Here are some examples of how to use the RockMoney module:

```php
// Parsing from a string with three numbers after a dot or comma, it will be parsed as thousands
echo $money->parse("1.001")->format();
// Output: 1.001,00 €

// Parsing from a PHP float, it will be parsed as float and rounded to cents
echo $money->parse(1.001)->format();
// Output: 1,00 €

// Arithmetic operations are supported
echo $money->parse("5,5")
  ->times(3)
  ->minus(2.5)
  ->plus(0.2)
  ->format();
// Output: 14,20 €

// Parsing from a string with a currency symbol
echo $money->parse("€ 1,234")->format();
// Output: 1.234,00 €

// Immutability is supported
$net = $money->parse("1.499");
$vat = $net->times(0.2);
$gross = $net->plus($vat);
echo "net: $net";     // Output: net: 1.499,00 €
echo "vat: $vat";     // Output: vat: 299,80 €
echo "gross: $gross"; // Output: gross: 1.798,80 €

// Manual formatting is supported
echo $money
  ->parse("5,5")
  ->format(decimal: '#', prefix: 'TEST: ', suffix: '!!');
// Output: TEST: 5#50 !!
```

## zeroNotEmpty

Sometimes zero (0) and blank ('') are not the same. For example you might want an optional price field that only shows up when filled out and to be hidden when empty. This is only possible if an empty field does not automatically show a price like 0,00€.

You choose between both behaviours in the field's settings. Blank values are possible if you choose `No - Blank and 0 have different meanings`.
