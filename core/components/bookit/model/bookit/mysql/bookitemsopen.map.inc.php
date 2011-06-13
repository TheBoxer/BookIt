<?php
$xpdo_meta_map['BookItemsOpen']= array (
  'package' => 'bookit',
  'table' => 'book_items_open',
  'fields' => 
  array (
    'idItem' => 0,
    'openDay' => 0,
    'openFrom' => NULL,
    'openTo' => NULL,
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
    'openDay' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'openFrom' => 
    array (
      'dbtype' => 'time',
      'phptype' => 'string',
      'null' => false,
    ),
    'openTo' => 
    array (
      'dbtype' => 'time',
      'phptype' => 'string',
      'null' => false,
    ),
  ),
  'aggregates' => 
  array (
    'OpenItem' => 
    array (
      'class' => 'BookItems',
      'local' => 'idItem',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
