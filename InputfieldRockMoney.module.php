<?php

namespace ProcessWire;

use RockMoney\Money;

/**
 * @author Bernhard Baumrock, 19.02.2023
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class InputfieldRockMoney extends InputfieldText
{

  public static function getModuleInfo()
  {
    return [
      'title' => 'RockMoney Inputfield',
      'version' => '0.0.1',
      'summary' => 'Inputfield for RockMoney',
      'icon' => 'money',
      'requires' => [
        'RockMoney',
      ],
      'installs' => [],
    ];
  }

  public function ___renderValue()
  {
    return $this->rockmoney()->parse($this->value);
  }

  /**
   * Prepare the 'value' attribute
   *
   * @param string $value
   * @return string
   * @throws WireException
   *
   */
  protected function setAttributeValue($value)
  {
    if ($value instanceof Money) return $value->getFloat();
    return $value;
  }

  /**
   * Process the Inputfield's input
   * @return $this
   */
  public function ___processInput($input)
  {
    $val = trim($input->get($this->name));
    $field = $this->wire->fields->get($this->name);

    if (!is_numeric($val)) $val = '';

    if ($val !== '') {
      // we have a value so we try to parse it
      $money = $this->rockmoney()->parse($val);
      $input->set($this->name, $money);
    } else {
      if ($field->zeroNotEmpty) {
        // zero and blank mean different things
        // we don't change anything, which will remove the db row
      } else $input->set($this->name, 0);
    }

    parent::___processInput($input);
  }

  public function rockmoney(): RockMoney
  {
    return $this->wire->modules->get('RockMoney');
  }
}
