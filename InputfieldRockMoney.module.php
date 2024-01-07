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

  /**
   * Render the Inputfield
   * @return string
   */
  public function ___render()
  {
    $html = parent::___render();
    $html = substr($html, 0, -2);
    $html .= " onfucus='this.select()' onclick='this.select()' />";
    return $html;
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
    return 0;
  }

  /**
   * Process the Inputfield's input
   * @return $this
   */
  public function ___processInput($input)
  {
    $val = $input->get($this->name);
    $money = $this->rockmoney()->parse($val ?: 0);
    $input->set($this->name, $money);
    parent::___processInput($input);
  }

  public function rockmoney(): RockMoney
  {
    return $this->wire->modules->get('RockMoney');
  }
}
