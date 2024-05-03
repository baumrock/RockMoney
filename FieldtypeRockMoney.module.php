<?php

namespace ProcessWire;

use RockMoney\Money;

/**
 * @author Bernhard Baumrock, 19.02.2023
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class FieldtypeRockMoney extends FieldtypeFloat
{

  public static function getModuleInfo()
  {
    return [
      'title' => 'RockMoney',
      'version' => '0.0.1',
      'summary' => 'RockMoney Fieldtype',
      'icon' => 'money',
      'requires' => [
        'RockMoney',
      ],
      'installs' => [],
    ];
  }

  public function init()
  {
    parent::init();
  }

  /** FIELDTYPE METHODS */

  public function ___formatValue(Page $page, Field $field, $value)
  {
    return $this->rockmoney()->parse($value);
  }

  public function getInputfield(Page $page, Field $field)
  {
    return $this->wire->modules->get('InputfieldRockMoney');
  }

  public function ___sleepValue(Page $page, Field $field, $value)
  {
    if ($value instanceof Money) return $value->getFloat();
    return (float)$value;
  }

  public function wakeupValue($page, $field, $value)
  {
    return $this->rockmoney()->parse($value);
  }

  /**
   * Sanitize value for storage
   *
   * @param Page $page
   * @param Field $field
   * @param string $value
   * @return string
   */
  public function sanitizeValue(Page $page, Field $field, $value)
  {
    if ($value === '' && $field->zeroNotEmpty) return '';
    return $this->rockmoney()->parse($value);
  }

  /** HELPER METHODS */

  public function rockmoney(): RockMoney
  {
    return $this->wire->modules->get('RockMoney');
  }
}
