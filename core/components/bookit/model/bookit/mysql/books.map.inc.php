<?php
$xpdo_meta_map['Books']= array (
  'package' => 'bookit',
  'table' => 'bookit_books',
  'fields' => 
  array (
    'idUser' => 0,
    'idItem' => 0,
    'bookDate' => 0,
    'bookFrom' => 0,
    'paid' => 0,
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
    'idItem' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'bookDate' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
    ),
    'bookFrom' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'paid' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
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
    'BookedItem' => 
    array (
      'class' => 'BookItems',
      'local' => 'idBookCustomer',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
