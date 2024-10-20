# Usage

## Formatting

All money objects will be automatically formatted according to the module settings:

<img src=https://i.imgur.com/ZWgywvX.png class=blur height=200>

### PHP

Using PHP, your money objects will automatically format themselves when requested for output:

```php
echo rockmoney()->parse(100); // 100,00€
```

### JS

Using JS, you need to pass the settings to the frontend. You can do that by adding the following to your html element:

```html
<html data-rockmoney='locale:en-US;currency:USD'>
```

```js
console.log(new RockMoney(100).format()); // 100,00€
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

## Examples

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
