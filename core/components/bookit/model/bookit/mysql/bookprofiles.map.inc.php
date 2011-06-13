<?php
$xpdo_meta_map['BookProfiles']= array (
  'package' => 'bookit',
  'table' => 'book_profiles',
  'fields' => 
  array (
    'idUser' => 0,
    'idBookCustomer' => 0,
    'discount' => 0,
  ),
  'fieldMeta' => 
  array (
    'idUser' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'idBookCustomer' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'discount' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'composites' => 
  array (
    'Customer' => 
    array (
      'class' => 'BookCustomers',
      'local' => 'idBookCustomer',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'idUser',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
