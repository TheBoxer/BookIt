<?php
$xpdo_meta_map['BookItems']= array (
  'package' => 'bookit',
  'table' => 'book_items',
  'fields' => 
  array (
    'name' => '',
    'active' => 0,
    'openschedule' => NULL,
    'pricing' => NULL,
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
    'openschedule' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => true,
    ),
    'pricing' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => true,
    ),
  ),
  'composites' => 
  array (
    'ItemsBooked' => 
    array (
      'class' => 'Books',
      'local' => 'id',
      'foreign' => 'idItem',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'ItemsOpenSchedule' => 
    array (
      'class' => 'OpenScheduleListItem',
      'local' => 'openschedule',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'ItemsPricing' => 
    array (
      'class' => 'PricingList',
      'local' => 'pricing',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
