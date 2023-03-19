<?php

namespace ProcessWire;

$info = [
  'title' => 'RockMoney',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'ProcessWire Module to provide tools for storing and using monetary values in an easy, yet powerful way.',
  'autoload' => true,
  'singular' => true,
  'icon' => 'money',
  'requires' => [
    'PHP>=8.0',
  ],
  'installs' => [
    'FieldtypeRockMoney',
    'InputfieldRockMoney',
  ],
];
