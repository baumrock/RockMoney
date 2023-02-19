<?php

namespace ProcessWire;

/**
 * @author Bernhard Baumrock, 19.02.2023
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class FieldtypeRockMoney extends FieldtypeText
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

  public function wakeupValue($page, $field, $value)
  {
    return $this->rockmoney()->parse($value);
  }

  public function getInputfield(Page $page, Field $field)
  {
    return $this->wire->modules->get('InputfieldRockMoney');
  }

  public function ___sleepValue(Page $page, Field $field, $value)
  {
    return $value->getFloat();
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
    return $value;
  }

  /** HELPER METHODS */

  public function rockmoney(): RockMoney
  {
    return $this->wire->modules->get('RockMoney');
  }
}
