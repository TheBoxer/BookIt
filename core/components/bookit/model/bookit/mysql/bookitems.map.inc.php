<?php
$xpdo_meta_map['BookItems']= array (
  'package' => 'bookit',
  'table' => 'book_items',
  'fields' => 
  array (
    'name' => '',
    'active' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
  ),
  'composites' => 
  array (
    'ItemOpen' => 
    array (
      'class' => 'BookItemsOpen',
      'local' => 'id',
      'foreign' => 'idItem',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'ItemsBooked' => 
    array (
      'class' => 'Books',
      'local' => 'id',
      'foreign' => 'idItem',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
