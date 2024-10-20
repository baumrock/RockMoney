<?php

namespace ProcessWire;

$info = [
  'title' => 'RockMoney',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'RockMoney Fieldtype',
  'icon' => 'money',
  'requires' => [
    'RockMoney',
  ],
];
