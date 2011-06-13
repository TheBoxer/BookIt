<?php
$xpdo_meta_map['BookCustomers']= array (
  'package' => 'bookit',
  'table' => 'book_customers',
  'fields' => 
  array (
    'lastName' => '',
  ),
  'fieldMeta' => 
  array (
    'lastName' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'CustomersProfile' => 
    array (
      'class' => 'BookProfiles',
      'local' => 'id',
      'foreign' => 'idBookCustomer',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'CustomersBooks' => 
    array (
      'class' => 'Books',
      'local' => 'id',
      'foreign' => 'idBookCustomer',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
