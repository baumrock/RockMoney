<?php

namespace ProcessWire;

use Money\Currency;
use NumberFormatter;
use RockMoney\Money;

/**
 * @author Bernhard Baumrock, 19.02.2023
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */

function rockmoney($value = null): RockMoney|Money
{
  if ($value !== null) return rockmoney()->parse($value);
  return wire()->modules->get('RockMoney');
}

require_once "Money.php";
require_once "vendor/autoload.php";
class RockMoney extends WireData implements Module, ConfigurableModule
{
  public $locale;
  public $currency;
  public $currencyStr;
  public $money;

  public function init()
  {
    try {
      $this->currency = new Currency($this->currencyStr);
    } catch (\Throwable $th) {
    }

    $this->locale = $this->locale ?: 'de-AT';
    $this->currencyStr = $this->currencyStr ?: 'EUR';

    // add $rockmoney API variable
    // if typecasted to string it returns the settings data-attribute
    $this->wire('rockmoney', $this);
    $this->dev();
  }

  /**
   * This method will only be executed if debug mode is enabled
   * and $config->rockdevtools = true;
   */
  private function dev(): void
  {
    $config = wire()->config;
    if ($config->ajax) return;
    if ($config->external) return;
    if (!$config->debug) return;
    if (!$config->rockdevtools) return;

    // compile all assets to one minified js file
    if (!wire()->modules->isInstalled('RockDevTools')) return;
    $tools = rockdevtools();
    $tools->assets()
      ->js()
      ->add(__DIR__ . '/src/*.js')
      ->save(__DIR__ . '/dst/RockMoney.min.js');
  }

  public function format($value): string
  {
    try {
      $f = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
      return $f->formatCurrency($value, $this->currencyStr);
    } catch (\Throwable $th) {
      throw new WireException("Your system does not support NumberFormatter - Please install the Intl extension for PHP.");
    }
  }

  /**
   * Create and return a new RockMoney\Money object
   */
  public function parse($data, $decimal = null): Money
  {
    if ($data instanceof Money) return $data;
    return new Money($data, $decimal);
  }

  public function settings(): string
  {
    return "data-rockmoney='locale:{$this->locale};currency:{$this->currencyStr}'";
  }

  public function __toString()
  {
    return $this->settings();
  }

  /** config */

  /**
   * Config inputfields
   * @param InputfieldWrapper $inputfields
   */
  public function getModuleConfigInputfields($inputfields)
  {
    $name = strtolower($this);
    $inputfields->add([
      'type' => 'markup',
      'label' => 'Documentation & Updates',
      'icon' => 'life-ring',
      'value' => "<p>Hey there, coding rockstars! 👋</p>
        <ul>
          <li><a class=uk-text-bold href=https://www.baumrock.com/modules/$name/docs>Read the docs</a> and level up your coding game! 🚀💻😎</li>
          <li><a class=uk-text-bold href=https://www.baumrock.com/rock-monthly>Sign up now for our monthly newsletter</a> and receive the latest updates and exclusive offers right to your inbox! 🚀💻📫</li>
          <li><a class=uk-text-bold href=https://github.com/baumrock/$name>Show some love by starring the project</a> and keep me motivated to build more awesome stuff for you! 🌟💻😊</li>
          <li><a class=uk-text-bold href=https://paypal.me/baumrockcom>Support my work with a donation</a>, and together, we'll keep rocking the coding world! 💖💻💰</li>
        </ul>",
    ]);

    foreach (
      [
        $this->wire->config->urls($this) . 'lib/currency.min.js',
        $this->wire->config->urls($this) . 'RockMoney.min.js',
      ] as $url
    ) {
      $url = $this->wire->config->versionUrl($url, true);
      $this->wire->config->scripts->add($url);
    }

    $inputfields->add([
      'type' => 'markup',
      'label' => 'Preview',
      'value' => $this->format(12345.67),
    ]);

    $curr = new InputfieldSelect();
    $curr->label = "Currency";
    $curr->icon = "money";
    $curr->name = "currencyStr";
    $curr->notes = "The currency is set globally for all objects. Default is EUR.";
    $curr->columnWidth = 50;
    require __DIR__ . '/currencies.php';
    $curr->value = $this->currencyStr;
    $inputfields->add($curr);

    $inputfields->add([
      'type' => 'text',
      'name' => 'locale',
      'label' => 'Locale',
      'columnWidth' => 50,
      'icon' => 'globe',
      'notes' => 'The locale used for formatting prices. Default is de-AT.',
      'value' => $this->locale,
    ]);

    return $inputfields;
  }
}
