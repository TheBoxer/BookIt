<?php
$xpdo_meta_map['BookItemPrices']= array (
  'package' => 'bookit',
  'table' => 'book_item_prices',
  'fields' => 
  array (
    'idItem' => 0,
    'priceFrom' => 0,
    'price' => 0,
  ),
  'fieldMeta' => 
  array (
    'idItem' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'priceFrom' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
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
  'aggregates' => 
  array (
    'Item' => 
    array (
      'class' => 'BookItemsOpen',
      'local' => 'idItem',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
  ),
);
