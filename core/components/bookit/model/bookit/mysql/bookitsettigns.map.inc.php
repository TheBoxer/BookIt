<?php
$xpdo_meta_map['BookItSettigns']= array (
  'package' => 'bookit',
  'table' => 'bookit_settings',
  'fields' => 
  array (
    'key' => NULL,
    'value' => NULL,
  ),
  'fieldMeta' => 
  array (
    'key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => false,
    ),
    'value' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'columns' => 
      array (
        'key' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
