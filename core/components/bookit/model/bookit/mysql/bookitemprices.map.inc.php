<?php
$xpdo_meta_map['BookItemPrices']= array (
  'package' => 'bookit',
  'table' => 'book_item_prices',
  'fields' => 
  array (
    'openDay' => 0,
    'priceFrom' => NULL,
    'priceTo' => NULL,
    'price' => 0,
  ),
  'fieldMeta' => 
  array (
    'openDay' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'priceFrom' => 
    array (
      'dbtype' => 'time',
      'phptype' => 'string',
      'null' => false,
    ),
    'priceTo' => 
    array (
      'dbtype' => 'time',
      'phptype' => 'string',
      'null' => false,
    ),
    'price' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
);
