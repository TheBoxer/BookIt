<?php
$xpdo_meta_map['PricingListItem']= array (
  'package' => 'bookit',
  'table' => 'bookit_book_pricing_list_items',
  'fields' => 
  array (
    'pricing_list' => NULL,
    'priceDay' => NULL,
    'priceFrom' => NULL,
    'priceTo' => NULL,
    'price' => NULL,
  ),
  'fieldMeta' => 
  array (
    'pricing_list' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
    ),
    'priceDay' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
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
    ),
  ),
  'aggregates' => 
  array (
    'Pricing' => 
    array (
      'class' => 'PricingList',
      'local' => 'pricing_list',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
