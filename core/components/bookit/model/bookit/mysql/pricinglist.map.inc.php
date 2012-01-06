<?php
$xpdo_meta_map['PricingList']= array (
  'package' => 'bookit',
  'table' => 'bookit_book_pricing_list',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
    'openschedule_list' => NULL,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'openschedule_list' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
    ),
  ),
  'composites' => 
  array (
    'PricingItem' => 
    array (
      'class' => 'PricingListItem',
      'local' => 'id',
      'foreign' => 'pricing_list',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'OpenSchedulePrice' => 
    array (
      'class' => 'OpenScheduleList',
      'local' => 'openschedule_list',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
