<?php

namespace RockMoney;

use Money\Money as MoneyMoney;
use ProcessWire\RockMoney;
use ProcessWire\Wire;

class Money extends Wire
{
  /** @var MoneyMoney */
  public $money;

  public function __construct($str, $decimal = null)
  {
    $this->parse($str, $decimal);
  }

  public function parse($str, $decimal = null): self
  {
    $_str = $str;

    // if a float value was provided we treat it as float
    // 1.45678 will convert to 146 cents!
    // 1.12345 will convert to 112 cents!
    if (is_float($str)) {
      $str = (string)$str;
      $decimal = ".";
    }

    // first we remove all non-numeric and non-dot values
    // but we keep a starting dash as it means negative values
    if (preg_match('/-?[0-9.,]+/', $str, $matches)) {
      $str = $matches[0];
    }

    // decimal parser
    if ($decimal == ".") {
      // decimal was set manually to "dot"
      // this makes it possible to parse numbers with many decimals
      // parse(0.123456789, ".") --> 12 cents
      // parse(0.56789, ".") --> 57 cents
      $str = str_replace(",", "", $str);
      $float = floatval($str);
      $str = (string)round($float, 2);
    } elseif ($decimal == ",") {
      // decimal was set manually to "comma"
      // this makes it possible to parse numbers with many decimals
      // parse(0,123456789, ",") --> 12 cents
      // parse(0,56789, ",") --> 57 cents
      $str = str_replace(".", "", $str);
      $str = str_replace(",", ".", $str);
      $float = floatval($str);
      $str = (string)round($float, 2);
    } else {
      // default decimal parser
      // assumes that a dot/comma followed by 3 digits is the thousands separator
      // 1.450 = 145000 cents
      // 1,450 = 145000 cents
      // 1,450.00 = 145000 cents
      // then we normalise the decimal and remove thousands separators
      $str = preg_replace('/(?<=\d)[,.](?=\d{3}\b)/', '', $str);
      // then we make sure we have a dot as decimal point
      $str = str_replace(",", ".", $str);
    }

    // convert it to cent value
    $parts = explode(".", $str);
    if (count($parts) === 1) $parts[1] = '00';
    $parts[1] = str_pad($parts[1], 2, "0", STR_PAD_RIGHT);
    $str = implode("", $parts);
    $str = ltrim($str, "0"); // remove leading zeros

    // bd($str, $_str);

    // create MoneyPhp object
    $curr = $this->rockmoney()->currency;
    $money = new MoneyMoney($str ?: 0, $curr);
    $this->money = $money;

    return $this;
  }

  /**
   * Format this money object for ouput
   */
  public function format(
    $thousands = null,
    $decimal = null,
    $prefix = null,
    $suffix = null,
    $space = null
  ): string {
    $m = $this->rockmoney();

    // prepare format
    $thousands = $thousands ?: $m->thousands;
    $decimal = $decimal ?: $m->decimal;
    $prefix = $prefix ?: $m->prefix;
    $suffix = $suffix ?: $m->suffix;
    $space = $space ?: $m->space;

    $amount = $this->money->getAmount();
    $str = number_format($amount / 100, 2, $decimal, $thousands);
    $space = $space ? " " : "";
    $str = $prefix . $space . $str . $space . $suffix;
    return trim($str);
  }

  /**
   * Get a string in the format that mollie needs it
   */
  public function formatMollie(): string
  {
    return number_format($this->getFloat(), 2, ".", "");
  }

  public function getFloat(): float
  {
    if (!$this->money) return 0;
    return $this->money->getAmount() / 100;
  }

  /** calculations */

  public function minus($amount): self
  {
    $new = clone $this;
    $minus = $this->rockmoney()->parse($amount);
    $new->money = $this->money->subtract($minus->money);
    return $new;
  }

  public function plus($amount): self
  {
    $new = clone $this;
    $plus = $this->rockmoney()->parse($amount);
    $new->money = $this->money->add($plus->money);
    return $new;
  }

  public function times($amount): self
  {
    $new = clone $this;
    $new->money = $this->money->multiply((string)$amount);
    return $new;
  }

  public function by($amount): self
  {
    $new = clone $this;
    $new->money = $this->money->divide((string)$amount);
    return $new;
  }

  /** comparison */

  public function isLessThan($money): bool
  {
    $money = $this->rockmoney()->parse($money);
    return $this->money->lessThan($money->money);
  }

  public function isLessThanOrEqual($money): bool
  {
    $money = $this->rockmoney()->parse($money);
    return $this->money->lessThanOrEqual($money->money);
  }

  public function isEqual($money): bool
  {
    $money = $this->rockmoney()->parse($money);
    return $this->money->equals($money->money);
  }

  public function isGreaterThanOrEqual($money): bool
  {
    $money = $this->rockmoney()->parse($money);
    return $this->money->greaterThanOrEqual($money->money);
  }

  public function isGreaterThan($money): bool
  {
    $money = $this->rockmoney()->parse($money);
    return $this->money->greaterThan($money->money);
  }

  /** other */

  public function __toString(): string
  {
    return $this->format();
  }

  public function rockmoney(): RockMoney
  {
    return $this->wire->modules->get("RockMoney");
  }

  public function __debugInfo(): array
  {
    return [
      'format' => $this->format(),
      'money' => $this->money,
    ];
  }
}
