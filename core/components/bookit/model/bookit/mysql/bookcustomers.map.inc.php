<?php
$xpdo_meta_map['BookCustomers']= array (
  'package' => 'bookit',
  'table' => 'book_customers',
  'fields' => 
  array (
    'lastName' => '',
    'firstName' => '',
    'phone' => '',
    'discount' => 0,
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
    'firstName' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'discount' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => 0,
    ),
  ),
  'composites' => 
  array (
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
