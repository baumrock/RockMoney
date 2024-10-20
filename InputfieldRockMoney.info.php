<?php

namespace ProcessWire;

$info = [
  'title' => 'RockMoney Inputfield',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'Inputfield for RockMoney',
  'icon' => 'money',
  'requires' => [
    'RockMoney',
  ],
];
