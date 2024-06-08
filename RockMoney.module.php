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

function rockmoney(): RockMoney
{
  return wire()->modules->get('RockMoney');
}

class RockMoney extends WireData implements Module, ConfigurableModule
{
  public $locale = 'de-AT';
  public $currency;
  public $currencyStr = 'EUR';
  public $money;

  public function init()
  {
    require_once "Money.php";
    require_once "vendor/autoload.php";
    $this->wire('money', $this);
    try {
      $this->currency = new Currency($this->currencyStr);
    } catch (\Throwable $th) {
    }

    // create minified js via RockMigrations
    $rm = $this->wire->modules->isInstalled('RockMigrations');
    if ($this->wire->user->isSuperuser() && $rm) {
      try {
        $rm = rockmigrations();
        $rm->minify(__DIR__ . '/RockMoney.js');
      } catch (\Throwable $th) {
        $this->log($th->getMessage());
      }
    }
  }

  public function format($value): string
  {
    $f = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
    return $f->formatCurrency($value, $this->currencyStr);
  }

  /**
   * Create and return a new RockMoney\Money object
   */
  public function parse($data, $decimal = null): Money
  {
    if ($data instanceof Money) return $data;
    return new Money($data, $decimal);
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

    foreach ([
      $this->wire->config->urls($this) . 'lib/currency.min.js',
      $this->wire->config->urls($this) . 'RockMoney.min.js',
    ] as $url) {
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
    $curr->addOptions([
      "AED" => "AED - United Arab Emirates dirham",
      "AFN" => "AFN - Afghan afghani",
      "ALL" => "ALL - Albanian lek",
      "AMD" => "AMD - Armenian dram",
      "ANG" => "ANG - Netherlands Antillean guilder",
      "AOA" => "AOA - Angolan kwanza",
      "ARS" => "ARS - Argentine peso",
      "AUD" => "AUD - Australian dollar",
      "AWG" => "AWG - Aruban florin",
      "AZN" => "AZN - Azerbaijani manat",
      "BAM" => "BAM - Bosnia and Herzegovina convertible mark",
      "BBD" => "BBD - Barbados dollar",
      "BDT" => "BDT - Bangladeshi taka",
      "BGN" => "BGN - Bulgarian lev",
      "BHD" => "BHD - Bahraini dinar",
      "BIF" => "BIF - Burundian franc",
      "BMD" => "BMD - Bermudian dollar",
      "BND" => "BND - Brunei dollar",
      "BOB" => "BOB - Boliviano",
      "BRL" => "BRL - Brazilian real",
      "BSD" => "BSD - Bahamian dollar",
      "BTN" => "BTN - Bhutanese ngultrum",
      "BWP" => "BWP - Botswana pula",
      "BYN" => "BYN - New Belarusian ruble",
      "BYR" => "BYR - Belarusian ruble",
      "BZD" => "BZD - Belize dollar",
      "CAD" => "CAD - Canadian dollar",
      "CDF" => "CDF - Congolese franc",
      "CHF" => "CHF - Swiss franc",
      "CLF" => "CLF - Unidad de Fomento",
      "CLP" => "CLP - Chilean peso",
      "CNY" => "CNY - Renminbi|Chinese yuan",
      "COP" => "COP - Colombian peso",
      "CRC" => "CRC - Costa Rican colon",
      "CUC" => "CUC - Cuban convertible peso",
      "CUP" => "CUP - Cuban peso",
      "CVE" => "CVE - Cape Verde escudo",
      "CZK" => "CZK - Czech koruna",
      "DJF" => "DJF - Djiboutian franc",
      "DKK" => "DKK - Danish krone",
      "DOP" => "DOP - Dominican peso",
      "DZD" => "DZD - Algerian dinar",
      "EGP" => "EGP - Egyptian pound",
      "ERN" => "ERN - Eritrean nakfa",
      "ETB" => "ETB - Ethiopian birr",
      "EUR" => "EUR - Euro",
      "FJD" => "FJD - Fiji dollar",
      "FKP" => "FKP - Falkland Islands pound",
      "GBP" => "GBP - Pound sterling",
      "GEL" => "GEL - Georgian lari",
      "GHS" => "GHS - Ghanaian cedi",
      "GIP" => "GIP - Gibraltar pound",
      "GMD" => "GMD - Gambian dalasi",
      "GNF" => "GNF - Guinean franc",
      "GTQ" => "GTQ - Guatemalan quetzal",
      "GYD" => "GYD - Guyanese dollar",
      "HKD" => "HKD - Hong Kong dollar",
      "HNL" => "HNL - Honduran lempira",
      "HRK" => "HRK - Croatian kuna",
      "HTG" => "HTG - Haitian gourde",
      "HUF" => "HUF - Hungarian forint",
      "IDR" => "IDR - Indonesian rupiah",
      "ILS" => "ILS - Israeli new shekel",
      "INR" => "INR - Indian rupee",
      "IQD" => "IQD - Iraqi dinar",
      "IRR" => "IRR - Iranian rial",
      "ISK" => "ISK - Icelandic króna",
      "JMD" => "JMD - Jamaican dollar",
      "JOD" => "JOD - Jordanian dinar",
      "JPY" => "JPY - Japanese yen",
      "KES" => "KES - Kenyan shilling",
      "KGS" => "KGS - Kyrgyzstani som",
      "KHR" => "KHR - Cambodian riel",
      "KMF" => "KMF - Comoro franc",
      "KPW" => "KPW - North Korean won",
      "KRW" => "KRW - South Korean won",
      "KWD" => "KWD - Kuwaiti dinar",
      "KYD" => "KYD - Cayman Islands dollar",
      "KZT" => "KZT - Kazakhstani tenge",
      "LAK" => "LAK - Lao kip",
      "LBP" => "LBP - Lebanese pound",
      "LKR" => "LKR - Sri Lankan rupee",
      "LRD" => "LRD - Liberian dollar",
      "LSL" => "LSL - Lesotho loti",
      "LYD" => "LYD - Libyan dinar",
      "MAD" => "MAD - Moroccan dirham",
      "MDL" => "MDL - Moldovan leu",
      "MGA" => "MGA - Malagasy ariary",
      "MKD" => "MKD - Macedonian denar",
      "MMK" => "MMK - Myanmar kyat",
      "MNT" => "MNT - Mongolian tögrög",
      "MOP" => "MOP - Macanese pataca",
      "MRO" => "MRO - Mauritanian ouguiya",
      "MUR" => "MUR - Mauritian rupee",
      "MVR" => "MVR - Maldivian rufiyaa",
      "MWK" => "MWK - Malawian kwacha",
      "MXN" => "MXN - Mexican peso",
      "MXV" => "MXV - Mexican Unidad de Inversion",
      "MYR" => "MYR - Malaysian ringgit",
      "MZN" => "MZN - Mozambican metical",
      "NAD" => "NAD - Namibian dollar",
      "NGN" => "NGN - Nigerian naira",
      "NIO" => "NIO - Nicaraguan córdoba",
      "NOK" => "NOK - Norwegian krone",
      "NPR" => "NPR - Nepalese rupee",
      "NZD" => "NZD - New Zealand dollar",
      "OMR" => "OMR - Omani rial",
      "PAB" => "PAB - Panamanian balboa",
      "PEN" => "PEN - Peruvian Sol",
      "PGK" => "PGK - Papua New Guinean kina",
      "PHP" => "PHP - Philippine peso",
      "PKR" => "PKR - Pakistani rupee",
      "PLN" => "PLN - Polish złoty",
      "PYG" => "PYG - Paraguayan guaraní",
      "QAR" => "QAR - Qatari riyal",
      "RON" => "RON - Romanian leu",
      "RSD" => "RSD - Serbian dinar",
      "RUB" => "RUB - Russian ruble",
      "RWF" => "RWF - Rwandan franc",
      "SAR" => "SAR - Saudi riyal",
      "SBD" => "SBD - Solomon Islands dollar",
      "SCR" => "SCR - Seychelles rupee",
      "SDG" => "SDG - Sudanese pound",
      "SEK" => "SEK - Swedish krona",
      "SGD" => "SGD - Singapore dollar",
      "SHP" => "SHP - Saint Helena pound",
      "SLL" => "SLL - Sierra Leonean leone",
      "SOS" => "SOS - Somali shilling",
      "SRD" => "SRD - Surinamese dollar",
      "SSP" => "SSP - South Sudanese pound",
      "STD" => "STD - São Tomé and Príncipe dobra",
      "SVC" => "SVC - Salvadoran colón",
      "SYP" => "SYP - Syrian pound",
      "SZL" => "SZL - Swazi lilangeni",
      "THB" => "THB - Thai baht",
      "TJS" => "TJS - Tajikistani somoni",
      "TMT" => "TMT - Turkmenistani manat",
      "TND" => "TND - Tunisian dinar",
      "TOP" => "TOP - Tongan paʻanga",
      "TRY" => "TRY - Turkish lira",
      "TTD" => "TTD - Trinidad and Tobago dollar",
      "TWD" => "TWD - New Taiwan dollar",
      "TZS" => "TZS - Tanzanian shilling",
      "UAH" => "UAH - Ukrainian hryvnia",
      "UGX" => "UGX - Ugandan shilling",
      "USD" => "USD - United States dollar",
      "UYI" => "UYI - Uruguay Peso en Unidades Indexadas",
      "UYU" => "UYU - Uruguayan peso",
      "UZS" => "UZS - Uzbekistan som",
      "VEF" => "VEF - Venezuelan bolívar",
      "VND" => "VND - Vietnamese đồng",
      "VUV" => "VUV - Vanuatu vatu",
      "WST" => "WST - Samoan tala",
      "XAF" => "XAF - Central African CFA franc",
      "XCD" => "XCD - East Caribbean dollar",
      "XOF" => "XOF - West African CFA franc",
      "XPF" => "XPF - CFP franc",
      "XXX" => "XXX - No currency",
      "YER" => "YER - Yemeni rial",
      "ZAR" => "ZAR - South African rand",
      "ZMW" => "ZMW - Zambian kwacha",
      "ZWL" => "ZWL - Zimbabwean dollar",
    ]);
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
