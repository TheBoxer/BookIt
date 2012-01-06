<?php
$xpdo_meta_map['OpenScheduleListItem']= array (
  'package' => 'bookit',
  'table' => 'bookit_book_openschedule_list_items',
  'fields' => 
  array (
    'openschedule_list' => NULL,
    'openDay' => NULL,
    'openFrom' => NULL,
    'openTo' => NULL,
  ),
  'fieldMeta' => 
  array (
    'openschedule_list' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
    ),
    'openDay' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
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
    'OpenSchedule' => 
    array (
      'class' => 'OpenScheduleList',
      'local' => 'openschedule_list',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
