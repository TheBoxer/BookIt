<?php
$xpdo_meta_map['OpenScheduleList']= array (
  'package' => 'bookit',
  'table' => 'bookit_book_openschedule_list',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
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
  ),
  'composites' => 
  array (
    'OpenScheduleItem' => 
    array (
      'class' => 'OpenScheduleListItem',
      'local' => 'id',
      'foreign' => 'openschedule_list',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'OpenSchedulePricingItem' => 
    array (
      'class' => 'PricingList',
      'local' => 'id',
      'foreign' => 'openschedule_list',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
