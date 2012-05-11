<?php
$xpdo_meta_map['BookItLog']= array (
  'package' => 'bookit',
  'table' => 'bookit_log',
  'fields' => 
  array (
    'type' => NULL,
    'customer' => NULL,
    'operator' => NULL,
    'day' => NULL,
    'hour' => NULL,
    'item' => NULL,
    'price' => NULL,
    'timeOfAction' => NULL,
  ),
  'fieldMeta' => 
  array (
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => false,
    ),
    'customer' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'integer',
      'null' => false,
    ),
    'operator' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'integer',
      'null' => false,
    ),
    'day' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'timestamp',
      'null' => true,
    ),
    'hour' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'integer',
      'null' => true,
    ),
    'item' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'integer',
      'null' => true,
    ),
    'price' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'integer',
      'null' => false,
    ),
    'timeOfAction' => 
    array (
      'dbtype' => 'int',
      'precision' => '32',
      'phptype' => 'timestamp',
      'null' => false,
    ),
  ),
  'aggregates' => 
  array (
    'UserCustomer' => 
    array (
      'class' => 'modUser',
      'local' => 'customer',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'UserOperator' => 
    array (
      'class' => 'modUser',
      'local' => 'operator',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'Item' => 
    array (
      'class' => 'BookItems',
      'local' => 'item',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
