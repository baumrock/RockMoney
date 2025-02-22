# Comparisons

RockMoney provides several methods to compare monetary values. All comparison methods automatically handle the parsing of input values, so you can compare against numbers, strings, or other Money objects.

## Available Methods

### isLessThan($money)
Checks if the amount is less than the provided value.
```php
$price = rockmoney(10);
$price->isLessThan(15); // returns true
$price->isLessThan("5"); // returns false
```

### isLessThanOrEqual($money)
Checks if the amount is less than or equal to the provided value.
```php
$price = rockmoney(10);
$price->isLessThanOrEqual(10); // returns true
$price->isLessThanOrEqual(5); // returns false
```

### isEqual($money)
Checks if the amount is exactly equal to the provided value.
```php
$price = rockmoney(10);
$price->isEqual(10); // returns true
$price->isEqual("10.00"); // returns true
$price->isEqual(15); // returns false
```

### isGreaterThanOrEqual($money)
Checks if the amount is greater than or equal to the provided value.
```php
$price = rockmoney(10);
$price->isGreaterThanOrEqual(10); // returns true
$price->isGreaterThanOrEqual(15); // returns false
```

### isGreaterThan($money)
Checks if the amount is greater than the provided value.
```php
$price = rockmoney(10);
$price->isGreaterThan(5); // returns true
$price->isGreaterThan(10); // returns false
```

## Input Formats

All comparison methods accept various input formats:
- Numbers (integers or floats)
- Strings containing numbers (with or without decimal points)
- Other RockMoney Money objects

The input is automatically parsed using the same rules as the Money object creation.
